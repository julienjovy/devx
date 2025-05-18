<?php

namespace App\Commands;

use App\Doctor\CheckMode;
use App\Doctor\FrameworkDetector;
use App\Doctor\PackageAdvisor;
use App\Doctor\ProjectScanner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

/* **

*/

class DoctorCommand extends Command
{
    protected static $defaultName = 'doctor';

    private InputInterface $input;

    private OutputInterface $output;

    protected function configure(): void
    {
        $this
            ->setName('doctor')
            ->setDescription('Checks your local development environment for required tools and project structure.')
            ->addOption(
                'project',
                'p',
                InputOption::VALUE_NONE,
                'Only run project-level checks (like .env, vendor/, artisan, etc.)'
            )
            ->addOption(
                'system',
                's',
                InputOption::VALUE_NONE,
                'Only check system tools (PHP, Composer, Node, Docker, etc.)'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'Run both project and system checks'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $io = new SymfonyStyle($this->input, $this->output);
        $io->title('🔍 devx doctor: checking your environment...');

        $composer = ProjectScanner::fileExists('composer.json') ? json_decode(file_get_contents('composer.json'), true) : [];
        $require = $composer['require'] ?? [];
        $requireDev = $composer['require-dev'] ?? [];

        $framework = FrameworkDetector::detect($require);
        $mode = CheckMode::fromInput($input);

        match ($mode) {
            CheckMode::SYSTEM => $this->runSystemChecks($io),
            CheckMode::PROJECT => $this->runProjectChecks($io, $framework, $require, $requireDev),
            CheckMode::ALL => (function () use ($io, $framework, $require, $requireDev) {
                $this->runSystemChecks($io);
                $this->runProjectChecks($io, $framework, $require, $requireDev);
            })()
        };

        return Command::SUCCESS;
    }

    private function runSystemChecks(SymfonyStyle $io): void
    {
        $io->section('🛠 System Tools');
        $this->checkTool($io, 'PHP', 'php -v', true);
        $this->checkTool($io, 'Composer', 'composer -V', true);
        $this->checkTool($io, 'Node.js', 'node -v');
        $this->checkTool($io, 'npm', 'npm -v');
        $this->checkTool($io, 'nvm', 'nvm --version');
        $this->checkTool($io, 'Docker', 'docker -v');
    }

    private function runProjectChecks(SymfonyStyle $io, ?string $framework, array $require, array $requireDev): void
    {
        $io->section('📁 Project structure');

        //@TODO: Output all the ok in one block
        $this->checkFileExists($io, '.env', '✅ .env file found', '⚠ .env missing');

        if ($framework === 'laravel') {
            $this->checkFileExists($io, 'artisan', '✔ Laravel project detected', '⚠ artisan not found — not a Laravel project?');
        }

        $this->checkDirExists($io, 'vendor', '✔ vendor/ exists', '⚠ vendor/ missing — run composer install');

        if (file_exists('package.json')) {
            $this->checkDirExists($io, 'node_modules', '✔ node_modules/ exists', '⚠ node_modules/ folder missing — run npm install');
        }

        if ($framework && $io->confirm("Do you want suggestions for useful $framework packages?", true)) {
            $suggestions = PackageAdvisor::getSuggestions($framework, $require, $requireDev);
            echo "<pre>";
            print_r($suggestions);
            die();

            if (empty($suggestions)) {
                $io->success("No missing popular packages detected for $framework.");
            } else {
                foreach ($suggestions as $category => $packages) {
                    $rows = [];
                    foreach ($packages as $pkg => $desc) {
                        $rows[] = [$pkg, $desc];
                    }
                    $io->table([strtoupper($category) . ' Package', 'Description'], $rows);
                }
                $flat = [];
                foreach ($suggestions as $group => $items) {
                    foreach ($items as $pkg => $desc) {
                        $flat[$pkg] = "$pkg — $desc";
                    }
                }

                /** @var QuestionHelper $helper */
                $helper = $this->getHelper('question');

                $question = new ChoiceQuestion(
                    'Which packages would you like to install?',
                    array_values($flat)
                );
                $question->setMultiselect(true);

                $selected = $helper->ask($this->input, $this->output, $question);
                $toInstall = array_keys(array_filter($flat, fn($desc) => in_array($desc, $selected)));

                if (! empty($toInstall)) {
                    $pkgList = implode(' ', $toInstall);
                    if ($io->confirm("Install now using Composer? [composer require $pkgList]", true)) {
                        $process = Process::fromShellCommandline("composer require $pkgList");
                        $process->run(function ($type, $buffer) use ($io) {
                            $io->write($buffer);
                        });

                        if ($process->isSuccessful()) {
                            $io->success('✅ Packages installed successfully.');
                        } else {
                            $io->error('❌ Composer installation failed.');
                        }
                    }
                }
            }
        }
    }
    /**
     * Check if a tool is installed and available in the system
     *
     * Executes a shell command to verify if a tool exists and is properly configured.
     * Displays success, warning or error message based on the command execution result.
     *
     * @param SymfonyStyle $io The SymfonyStyle instance to handle command output
     * @param string $name The name of the tool being checked
     * @param string $command The shell command to verify tool existence/version
     * @param bool $required Whether the tool is required (error) or optional (warning)
     * @return void
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException When proc_open is not installed
     * @throws \Symfony\Component\Process\Exception\LogicException When process is already running
     *
     * */
    private function checkTool(SymfonyStyle $io, string $name, string $command, bool $required = false): void
    {
        $process = Process::fromShellCommandline($command);
        $process->run();

        $output = $process->getOutput() . $process->getErrorOutput();
        $lines = preg_split("/(\r\n|\n|\r)/", $output);
        $firstLine = '';
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '') {
                $firstLine = $line;
                break;
            }
        }

        if ($process->isSuccessful()) {
            $io->success("✔ $name: $firstLine");
        } else {
            $message = "✘ $name not found";
            $required ? $io->error($message) : $io->warning($message);
        }
    }

    private function checkFileExists(SymfonyStyle $io, string $file, string $ok, string $warn): void
    {
        ProjectScanner::fileExists($file) ? $io->success($ok) : $io->warning($warn);
    }

    private function checkDirExists(SymfonyStyle $io, string $dir, string $ok, string $warn): void
    {
        ProjectScanner::dirExists($dir) ? $io->success($ok) : $io->warning($warn);
    }
}
