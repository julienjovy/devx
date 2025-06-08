<?php

namespace App\Services\PackageManager\Laravel;

use App\Services\PackageManager\PackageManagerService;
use App\Traits\managePackage;
use Symfony\Component\Console\Style\SymfonyStyle;

class LaravelService extends PackageManagerService
{
    use managePackage;

    public static string $managerName = 'laravel installer';

    public static ?string $binName = 'laravel';

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
