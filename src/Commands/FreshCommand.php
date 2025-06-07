<?php

namespace App\Commands;

use App\Services\PackageManager\Manager as PackageManager;
use App\Services\PackageManager\PackageManagerInterface;
use App\Utils\Logo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class FreshCommand extends Command
{
    private PackageManagerInterface $packageManager;

    public function __construct()
    {
        parent::__construct('fresh');
        $this->packageManager = new (PackageManager::resolve())();
    }

    protected function configure(): void
    {
        $this->setName('fresh');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        Logo::render($io, 'FRESH');

        $this->packageManager::confirmUsage($io);

        $found = [];
        $missing = [];

        $checks = [
            'chocolatey' => 'choco -v',
            'node' => 'node -v',
            'npm' => 'npm -v',
            'nvm' => 'nvm --version',
            'github-cli' => 'insomnia --version',
            'wsl' => 'wsl --version',
        ];

        $io->writeln('<info>Checking for basic dev tools</info>');

        foreach ($checks as $tool => $command) {
            $process = Process::fromShellCommandline($command);
            $process->run();

            if ($process->isSuccessful()) {
                $found[] = $tool;
            } else {
                $missing[] = $tool;
            }
        }

        $io->newLine(2);

        if (! empty($found)) {
            $io->section('✔ Tools found');
            foreach ($found as $tool) {
                $io->writeln("<fg=green>✔</> <info>$tool</info>");
            }
        }
        $io->newLine(2);

        if (! empty($missing)) {
            $io->section('⚠ Tools missing');
            foreach ($missing as $tool) {
                $io->writeln("<fg=yellow>x</> <comment>$tool</comment>");
            }
            foreach ($missing as $tool) {
                if ($io->confirm("do you wish to install <comment>$tool</comment>?")) {
                    $this->packageManager->install($tool);
                } else {
                    $io->newLine();
                    $io->writeln("$tool won't be installed you can run <comment>devx install:".strtolower($tool).'</comment>');
                }
            }
        }

        return Command::SUCCESS;
    }
}
