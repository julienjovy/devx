<?php

namespace App\PackageManager;

use Symfony\Component\Console\Style\SymfonyStyle;

interface PackageManagerInterface
{
    /**
     * Check if this package manager is available on the current system.
     */
    public static function isAvailable(): bool;

    /**
     * Determine whether a given package is already installed.
     */
    public static function isPackageInstalled(string $package): bool;

    /**
     * Install a package using the package manager.
     */
    public static function install(string $package): bool;

    /**
     * Ensure a package is installed; may provide console feedback.
     */
    public static function ensureInstalled(string $package, SymfonyStyle $io): void;
}
