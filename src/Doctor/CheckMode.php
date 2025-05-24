<?php

namespace App\Doctor;

use Symfony\Component\Console\Input\InputInterface;

enum CheckMode
{
    case SYSTEM;
    case PROJECT;
    case ALL;

    public static function fromInput(InputInterface $input): self
    {
        if ($input->getOption('all')) {
            return self::ALL;
        }
        if ($input->getOption('system')) {
            return self::SYSTEM;
        }
        if ($input->getOption('project')) {
            return self::PROJECT;
        }

        // Par défaut : mode PROJECT
        return self::PROJECT;
    }
}
