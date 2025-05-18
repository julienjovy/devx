<?php

namespace App\PackageManager;

use App\Utils\Shell;
use Symfony\Component\Console\Style\SymfonyStyle;

class Chocolatey implements PackageManagerInterface
{
    /**
     * Check if Chocolatey is available on the system.
     */
    public static function isAvailable(): bool
    {
        return Shell::runVersionCommand('choco -v') !== null;
    }

    /**
     * Check if a given package is already installed via Chocolatey.
     */
    public static function isPackageInstalled(string $package): bool
    {
        $output = Shell::runVersionCommand("choco list --local-only --exact $package");
        return $output !== null && str_contains(strtolower($output), strtolower($package));
    }

    /**
     * Install a given package using Chocolatey.
     */
    public static function install(string $package): bool
    {
        $command = "choco install $package -y";
        $output = Shell::runVersionCommand($command);
        return $output !== null;
    }

    /**
     * Ensure that a package is installed, prompting installation if needed.
     */
    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        if (!self::isAvailable()) {
            $io->error("Chocolatey is not installed on this system.");
            return;
        }

        if (self::isPackageInstalled($package)) {
            $io->success("✔ $package is already installed.");
            return;
        }

        $io->warning("⚠ $package is not installed.");
        if ($io->confirm("Do you want to install $package using Chocolatey?", true)) {
            $io->section("Installing $package...");
            if (self::install($package)) {
                $io->success("✅ $package installed successfully.");
            } else {
                $io->error("❌ Failed to install $package with Chocolatey.");
            }
        }
    }
}
