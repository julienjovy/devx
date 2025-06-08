<?php

namespace App\Services\PackageManager\Homebrew;

use App\Services\PackageManager\PackageManagerService;
use App\Traits\managePackage;
use Symfony\Component\Console\Style\SymfonyStyle;

class HomebrewService extends PackageManagerService
{
    use managePackage;

    public static string $managerName = 'homebrew';

    public static ?string $binName = 'brew';

    public static function install(string $packageName): bool
    {
        // TODO: Implement install() method.
    }

    public static function isPackageInstalled(string $package): bool
    {
        // TODO: Implement isPackageInstalled() method.
    }

    public static function ensureInstalled(string $package, SymfonyStyle $io): void
    {
        // TODO: Implement ensureInstalled() method.
    }

    public function installByToolName(string $toolName): bool
    {
        // TODO: Implement installByToolName() method.
    }

    public static function getLatestVersion(): string
    {
        $output = @file_get_contents('https://api.github.com/repos/Homebrew/brew/tags', false, stream_context_create([
            'http' => [
                'user_agent' => 'devx-package-checker',
            ],
        ]));

        if (! $output) {
            return 'unknown';
        }

        $tags = json_decode($output, true);

        if (isset($tags[0]['name'])) {
            return ltrim($tags[0]['name'], 'v');
        }

        return 'unknown';
    }
}
