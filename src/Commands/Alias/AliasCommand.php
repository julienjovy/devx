<?php

namespace App\Commands\Alias;

use App\Services\AliasMaker\AliasMakerInterface;
use App\Services\AliasMaker\Docker\Docker;
use App\Services\AliasMaker\Kubectl\Kubectl;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $managers = [
            Docker::class,
            Kubectl::class,
        ];


        /* @var $manager AliasMakerInterface */
        foreach ($managers as $manager) {
            $manager::generateAliasFile();
        }


        return Command::SUCCESS;

    }
}
