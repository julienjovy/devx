<?php

namespace App\Commands;

use App\Services\PackageManager\Manager as PackageManager;
use App\Services\PackageManager\PackageManagerInterface;
use App\Utils\Logo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $io->write("\033\143");

        Logo::render($io, 'FRESH');
        $io->newLine(2);
        $this->packageManager::getInstalledPackageManager($io);

        return Command::SUCCESS;
    }
}
