<?php

namespace App\Services\PackageManager\Homebrew;

use App\Services\PackageManager\PackageManagerService;
use App\Traits\managePackage;
use Symfony\Component\Console\Style\SymfonyStyle;

class HomebrewService extends PackageManagerService
{
    use managePackage;

    public static string $managerName = 'homebrew';

    public static ?string $binName = 'brew';

    public static function install(string $packageName): bool
    {
        // TODO: Implement install() method.
    }

    public static function isPackageInstalled(string $package): bool
    {
        // TODO: Implement isPackageInstalled() method.
    }

    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        // TODO: Implement ensureInstalled() method.
    }

    public function installByToolName(string $toolName): bool
    {
        // TODO: Implement installByToolName() method.
    }
}
