<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class FreshCommand extends Command
{
    protected function configure()
    {
        $this->setName('fresh');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $checks = [
            'node' => 'node -v',
            'npm' => 'npm -v',
            'nvm' => 'nvm --version',
        ];

        foreach ($checks as $tool => $command) {
            $process = Process::fromShellCommandline($command);
            $process->run();

            if (! $process->isSuccessful()) {
                $io->warning("$tool is not installed or not in PATH.");

                if ($tool === 'nvm') {
                    $installCmd = match (PHP_OS_FAMILY) {
                        'Windows' => 'winget install CoreyButler.NVMforWindows',
                        'Darwin', 'Linux' => 'curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash',
                        default => null,
                    };
                }

                if ($tool === 'node') {
                    $installCmd = match (PHP_OS_FAMILY) {
                        'Windows' => 'winget install OpenJS.NodeJS',
                        'Darwin' => 'brew install node',
                        'Linux' => 'sudo apt install nodejs -y',
                        default => null,
                    };
                }

                if (isset($installCmd)) {
                    if ($io->confirm("Do you want to install $tool now?")) {
                        $install = Process::fromShellCommandline($installCmd);
                        $install->setTty(Process::isTtySupported());
                        $install->run(function ($_, $buffer) use ($io) {
                            $io->write($buffer);
                        });

                        if ($install->isSuccessful()) {
                            $io->success("$tool was installed successfully.");
                        } else {
                            $io->error("Failed to install $tool. You might need to do it manually.");
                        }
                    }
                }
            } else {
                $io->success("$tool found: ");
            }
        }

        return Command::SUCCESS;
    }
}
