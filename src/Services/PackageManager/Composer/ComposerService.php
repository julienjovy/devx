<?php

namespace App\Services\PackageManager\Composer;

use App\Enums\ChocolateyPackage;
use App\Services\PackageManager\PackageManagerService;
use App\Traits\managePackage;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class ComposerService extends PackageManagerService
{
    use managePackage;

    public static string $managerName = 'composer';

    public static function install(string $packageName): bool
    {
        $process = Process::fromShellCommandline("composer require {$packageName}");

        return $process->run() !== 0;
    }

    public static function getManagerVersion(): string
    {
        $process = Process::fromShellCommandline(static::getBinName().' --version');
        $process->run();

        $output = trim($process->getOutput());

        // Regex pour capturer un versionnement sémantique simple, optionnellement avec pré-release ou build metadata
        if (preg_match('/\d+\.\d+\.\d+(-[0-9A-Za-z-.]+)?(\+[0-9A-Za-z-.]+)?/', $output, $matches)) {
            return 'v'.$matches[0];
        }

        // Sinon retourne la sortie brute préfixée par V (fallback)
        return 'v'.$output;
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
