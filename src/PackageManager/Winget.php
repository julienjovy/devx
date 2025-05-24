<?php

use App\PackageManager\PackageManagerInterface;
use App\Utils\Shell;
use Symfony\Component\Console\Style\SymfonyStyle;

class Winget implements PackageManagerInterface
{
    public static function isAvailable(): bool
    {
        return Shell::runVersionCommand('winget -v') !== null;
    }

    public static function isPackageInstalled(string $package): bool
    {
        return false;
    }

    public static function install(string $package): bool
    {
        Shell::runCommand('winget install $package');

        return true;
    }

    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        if ((! self::isAvailable())) {
            $io->error('winget is not installed on this system');
        }
    }
}
