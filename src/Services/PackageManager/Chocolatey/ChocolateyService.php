<?php

namespace App\Services\PackageManager\Chocolatey;

use App\Enums\ChocolateyPackage;
use App\Services\PackageManager\PackageManagerService;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class ChocolateyService extends PackageManagerService
{
    public static string $managerName = 'chocolatey';

    public static ?string $binName = 'choco';

    public static function install(string $packageName): bool
    {
        $process = Process::fromShellCommandline("choco install {$packageName} -y");

        return $process->run() !== 0;
    }

    public function installByToolName(string $toolName): bool
    {
        $pkg = ChocolateyPackage::findByToolName($toolName);

        return $pkg && $this->install($pkg->value);
    }

    public static function isPackageInstalled(string $package): bool
    {
        return Process::fromShellCommandline("choco list {$package}")->run() !== 0;
    }

    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        // TODO: Implement ensureInstalled() method.
    }
}
