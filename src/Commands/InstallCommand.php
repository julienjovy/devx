<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('install')
            ->setDescription('Install a full Laravel + Nuxt development environment.')
            ->addOption('stack', 's', InputOption::VALUE_REQUIRED, 'The tech stack to install (e.g., laravel-nuxt)', 'laravel-nuxt')
            ->addOption('project', 'p', InputOption::VALUE_REQUIRED, 'Project name', 'my-app')
            ->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Installation path', getcwd())
            ->addOption(
                'mode',
                null,
                InputOption::VALUE_REQUIRED,
                'Installation mode: "fullstack" or "split"',
                'split'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stack = $input->getOption('stack');
        $project = $input->getOption('project');
        $path = rtrim($input->getOption('path'), '/').'/'.$project;
        $mode = $input->getOption('mode');

        if ($stack !== 'laravel-nuxt') {
            $output->writeln("<error>Unsupported stack: $stack</error>");

            return Command::FAILURE;
        }

        if (! in_array($mode, ['split', 'fullstack'])) {
            $output->writeln('<error>Invalid mode: '.$mode.'. Use "split" or "fullstack".</error>');

            return Command::FAILURE;
        }

        $output->writeln("<info>🚀 Installing Laravel + Nuxt stack in:</info> $path\n");

        $fs = new Filesystem;
        if (! $fs->exists($path)) {
            $fs->mkdir($path);
        }

        $laravelPath = "$path/backend";
        $nuxtPath = "$path/frontend";

        $this->runProcess(['composer', 'create-project', 'laravel/laravel', $laravelPath], $output, 'Creating Laravel app');
        $this->runProcess(['composer', 'require', 'laravel/fortify'], $output, 'Installing Fortify', $laravelPath);
        $this->runProcess(['php', 'artisan', 'vendor:publish', '--provider=\"Laravel\\Fortify\\FortifyServiceProvider\"'], $output, 'Publishing Fortify config', $laravelPath);

        $this->runProcess(['composer', 'require', 'laravel/passport'], $output, 'Installing Passport', $laravelPath);
        $this->runProcess(['php', 'artisan', 'migrate'], $output, 'Running migrations', $laravelPath);
        $this->runProcess(['php', 'artisan', 'passport:install'], $output, 'Installing Passport keys', $laravelPath);

        $this->runProcess(['npx', 'nuxi', 'init', $nuxtPath], $output, 'Creating Nuxt app');
        $this->runProcess(['npm', 'install'], $output, 'Installing Nuxt dependencies', $nuxtPath);

        $output->writeln("\n<info>✅ Laravel + Nuxt stack installed successfully!</info>");

        return Command::SUCCESS;
    }

    private function runProcess(array $command, OutputInterface $output, string $label, ?string $workingDir = null): void
    {
        $output->writeln("<comment>→ $label...</comment>");
        $process = new Process($command, $workingDir);
        $process->setTimeout(null);
        $process->run(function ($_, $buffer) use ($output) {
            $output->write($buffer);
        });
    }
}
