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

    abstract public static function getLatestVersion(): string;

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
                $newestVersion = $managerClass::getLatestVersion() !== '' ? $managerClass::getLatestVersion() : "<comment>unknown</comment>";
                $installed[] = [
                    'name' => $managerClass::$managerName,
                    'version' => '<info>'.$managerClass::getManagerVersion().'</info>',
                    'new_version' => $newestVersion,
                ];
            } else {
                $notInstalled[] = [
                    'name' => $managerClass::managerName(),
                    'version' => '<comment>not present</comment>',
                    'new_version' => $managerClass::getLatestVersion(),
                ];
            }
            $progress->advance();
        }

        $progress->finish();
        $progress->clear();
        $io->section('Package managers detected');
        $table = new Table($io);
        $table->setHeaders(['Name', 'Version', 'Newest version']);
        $table->addRows([...$installed, ...$notInstalled]);
        $table->setColumnWidths(['30', '15']);
        $table->render();

        $wanted = [ChocolateyService::$managerName, WingetService::$managerName];

        $matches = array_filter($installed, function ($item) use ($wanted) {
            return in_array($item['name'], $wanted, true);
        });

        if (count($matches) > 1) {

            $choices = array_column($matches, 'name');
            $question ="<comment>" . count($choices) . " package managers detected [" . implode(' / ', $choices). "]</comment> \nWhich one would you like to use ?";
            $default = $choices[0] ?? null;
            $selected = $io->choice(
                $question,
                $choices,
                $default
            );
        }

    }
}
