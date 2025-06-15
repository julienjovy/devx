<?php

namespace App\Commands\Alias;

use App\Services\AliasMaker\AliasMakerInterface;
use App\Services\AliasMaker\Docker\Docker;
use App\Services\AliasMaker\Kubectl\Kubectl;
use App\Utils\Logo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AliasCommand extends Command
{
    protected static $defaultName = 'alias:all';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);

        Logo::render($io, 'ALIAS');
        $managers = [
            Docker::class,
            Kubectl::class,
        ];


        /* @var $manager AliasMakerInterface */
        foreach ($managers as $manager) {
            $io->writeln(sprintf('<info>Generating aliases for %s</info>', $manager::$name));
            $manager::generateAliasFile();
        }


        return Command::SUCCESS;

    }
}
