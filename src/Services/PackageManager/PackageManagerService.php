<?php

namespace App\Services\PackageManager;

use App\Services\PackageManager\Chocolatey\ChocolateyService;
use App\Services\PackageManager\Composer\ComposerService;
use App\Services\PackageManager\Homebrew\HomebrewService;
use App\Services\PackageManager\Laravel\LaravelService;
use App\Services\PackageManager\Npm\NpmService;
use App\Services\PackageManager\Winget\WingetService;
use App\Traits\managePackage;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

abstract class PackageManagerService implements PackageManagerInterface
{
    use managePackage;

    public static string $managerName;

    public static ?string $binName = null;

    public static function getBinName(): string
    {
        return static::$binName ?? static::$managerName;
    }

    public static function isAvailable(): bool
    {
        $process = Process::fromShellCommandline(static::getBinName().' -v');
        $process->run();

        return $process->isSuccessful();
    }

    abstract public static function install(string $packageName): bool;

    abstract public static function isPackageInstalled(string $package): bool;

    abstract public static function ensureInstalled(string $package, SymfonyStyle $io): void;

    abstract public function installByToolName(string $toolName): bool;

    public static function managerName(): string
    {
        return static::$managerName;
    }

    public static function getManagerVersion(): string
    {
        $process = Process::fromShellCommandline(static::getBinName().' --version');
        $process->run();

        $output = trim($process->getOutput());

        if (preg_match('/\d+\.\d+\.\d+(-[0-9A-Za-z-.]+)?(\+[0-9A-Za-z-.]+)?/', $output, $matches)) {
            return 'v'.$matches[0];
        }

        return 'v'.$output;
    }

    public static function getInstalledPackageManager(SymfonyStyle $io): void
    {
        /** @var class-string<PackageManagerInterface>[] $managers */
        $managers = [
            ChocolateyService::class,
            WingetService::class,
            NpmService::class,
            ComposerService::class,
            LaravelService::class,
            HomebrewService::class,
        ];

        $installed = [];
        $notInstalled = [];

        $io->section('Scanning installed package managers...');

        $progress = $io->createProgressBar(count($managers));
        $progress->start();

        foreach ($managers as $managerClass) {
            if ($managerClass::isAvailable()) {
                $installed[] = [
                    'name' => $managerClass::managerName(),
                    'text' => '<info>'.$managerClass::getManagerVersion().'</info>',
                ];
            } else {
                $notInstalled[] = [
                    'name' => $managerClass::managerName(),
                    'text' => '<comment>not present</comment>',
                ];
            }
            $progress->advance();
        }

        $progress->finish();
        $io->newLine(2);
        $table = new Table($io);
        $table->setHeaders(['Name', 'Version']);
        $table->addRows([...$installed, ...$notInstalled]);
        $table->setColumnWidths(['30', '15']);
        $table->render();

    }
}
