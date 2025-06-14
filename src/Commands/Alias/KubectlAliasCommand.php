<?php

namespace App\Commands\Alias;

use App\Services\AliasMaker\Kubectl\Kubectl;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class KubectlAliasCommand extends Command
{
    public function __construct()
    {
        parent::__construct('alias:kube');
    }

    public function configure() {}

    public function execute(InputInterface $input, OutputInterface $output)
    {

        Kubectl::generateAliasFile();

        return Command::SUCCESS;

    }
}
