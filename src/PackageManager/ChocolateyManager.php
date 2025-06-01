<?php

// src/PackageManager/Chocolatey.php

namespace App\PackageManager;

use App\Enums\ChocolateyPackage;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class ChocolateyManager implements PackageManagerInterface
{
    public static function isAvailable(): bool
    {
        return Process::fromShellCommandline('choco -v')->run() === 0;
    }

    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        // Pas utilisé ici
    }

    public static function install(string $package): void
    {
        $process = Process::fromShellCommandline("choco install {$package} -y");
        $process->run();
    }

    public function installByToolName(string $toolName): bool
    {
        $pkg = ChocolateyPackage::findByToolName($toolName);

        return $pkg ? $this->install($pkg->value) : false;
    }

    public static function isPackageInstalled(string $package): bool
    {
        return true;
    }
}
