<?php

namespace App\Services\PackageManager\Javascript;

use App\Enums\NpmPackage;
use App\Services\PackageManager\PackageManagerService;
use App\Traits\managePackage;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class NpmService extends PackageManagerService
{
    use managePackage;

    public static string $managerName = 'npm';

    public static function install(string $packageName): bool
    {
        $process = Process::fromShellCommandline("npm install {$packageName}");

        return $process->run() !== 0;
    }

    public function installByToolName(string $toolName): bool
    {
        $pkg = NpmPackage::findByToolName($toolName);

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

    public static function getLatestVersion(): string
    {
        exec('npm view npm version', $output);

        return trim($output[0] ?? '');
    }
}
