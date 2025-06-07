<?php

namespace App\Services;

use App\Services\PackageManager\PackageManagerInterface;
use App\Traits\managePackage;
use App\Utils\Shell;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

abstract class AbstractPackageManager implements PackageManagerInterface
{
    use managePackage;

    public static string $managerName;

    public static function isAvailable(): bool
    {
        return Process::fromShellCommandline(static::$managerName .' -v')->run() === 0;
    }

    abstract public static function install(string $packageName): bool;

    abstract public static function isPackageInstalled(string $package): bool;

    abstract public static function ensureInstalled(string $package, SymfonyStyle $io): void;

    abstract public function installByToolName(string $toolName): bool;

    public static function managerName(): string
    {
        return static::$managerName;
    }
}
