<?php

namespace App\Traits;

use Symfony\Component\Console\Style\SymfonyStyle;

trait managePackage
{
    public static function resolve(): string
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }

    public static function confirmUsage(SymfonyStyle $io): bool
    {
        $io->section('Package manager');
        $io->writeln('<comment>' .static::managerName() . "</comment> has been detected on your system. It has been selected has prefered tool for package management");
        return $io->confirm('Are you sure you want to use '.static::managerName().' to manage your packages ?', true);

    }
}
