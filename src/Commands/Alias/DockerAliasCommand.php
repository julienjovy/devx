<?php

namespace App\Commands\Alias;

use App\Services\AliasMaker\Docker\Docker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DockerAliasCommand extends Command
{
    public function __construct()
    {
        parent::__construct('alias:docker');
    }

    public function configure() {}

    public function execute(InputInterface $input, OutputInterface $output): int
    {

        Docker::generateAliasFile();

        return Command::SUCCESS;

    }
}
