<?php

namespace App\Services\PackageManager\Winget;

use App\Enums\WingetPackage;
use App\Services\AbstractPackageManager;
use App\Traits\managePackage;
use App\Utils\Shell;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class WingetManager extends AbstractPackageManager
{
    use managePackage;

    public static string $managerName = 'winget';

    public static function isPackageInstalled(string $packageName): bool
    {
        $package = WingetPackage::get($packageName)->value;
        $process = Process::fromShellCommandline("winget list --id {$package} --source winget");
        $process->run();

        return $process->isSuccessful() && str_contains($process->getOutput(), $package);
    }

    public static function install(string $packageName): bool
    {
        $wingetPackage = WingetPackage::get($packageName);
        if (! $wingetPackage) {

        }
        if (self::isPackageInstalled($packageName)) {
            exit("package $packageName is already installed");
        } else {
            exit('package '.$packageName.' is not installed');
        }
        return Shell::runInstallCommand(static::$managerName . "install --id {$wingetPackage->value} -e");
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

        return $this->install($package->value);
    }
}
