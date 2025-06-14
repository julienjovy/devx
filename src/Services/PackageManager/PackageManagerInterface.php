<?php

namespace App\Services\PackageManager;

use Symfony\Component\Console\Style\SymfonyStyle;

interface PackageManagerInterface
{
    public static function resolve(): string;

    /**
     * Check if this package manager is available on the current system.
     */
    public static function isAvailable(): bool;

    public static function confirmUsage(SymfonyStyle $io): bool;

    /**
     * Determine whether a given package is already installed.
     */
    public static function isPackageInstalled(string $packageName): bool;

    /**
     * Install a package using the package manager.
     */
    public static function install(string $packageName): bool;

    /**
     * Ensure a package is installed; may provide console feedback.
     */
    public static function ensureInstalled(string $package, SymfonyStyle $io): void;

    public function installByToolName(string $toolName): bool;

    public static function getLatestVersion(): string;
}
