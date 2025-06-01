<?php

namespace App\PackageManager;

use App\Enums\WingetPackage;
use App\Utils\Shell;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class WingetManager implements PackageManagerInterface
{
    public static function isAvailable(): bool
    {
        return Shell::runVersionCommand('winget -v') !== null;
    }

    public static function isPackageInstalled(string $packageName): bool
    {
        $package = WingetPackage::get($packageName)->value;
        $process = Process::fromShellCommandline("winget list --id {$package} --source winget");
        $process->run();

        return $process->isSuccessful() && str_contains($process->getOutput(), $package);
    }

    public static function install(string $package): void
    {
        $wingetPackage = WingetPackage::get($package);
        if (! $wingetPackage) {

        }
        if (self::isPackageInstalled($package)) {
            exit("package $package is already installed");
        } else {
            exit('package '.$package.' is not installed');
        }
        Shell::runInstallCommand("winget install --id {$wingetPackage->value} -e");
    }

    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        if ((! self::isAvailable())) {
            $io->error('winget is not installed on this system');
        }
    }

    public function installByToolName(string $toolName): bool
    {

        $package = WingetPackage::get($toolName);

        if (! $package) {
            return false;
        }

        $this->install($package->value);
    }
}
