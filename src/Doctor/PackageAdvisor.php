<?php

namespace App\Doctor;

use App\Utils\Packagist;

class PackageAdvisor
{
    public static function getSuggestions(string $framework, array $require, array $requireDev): array
    {
        $installed = array_merge(array_keys($require), array_keys($requireDev));
        $topPackages = self::getTopPackagesFor($framework);

        $suggestions = [];

        foreach ($topPackages as $package => $description) {
            if (! in_array($package, $installed, true)) {
                $suggestions[$package] = $description;
            }
        }

        return $suggestions;
    }

    public static function getTopPackagesFor(string $framework): array
    {
        return match ($framework) {
            'laravel' => self::getAuthPackagesWithDescriptions(),
            'symfony' => self::symfonyTop10(),
            default => [],
        };
    }

    private static function laravelTop10(): array
    {
        return [
            'barryvdh/laravel-debugbar' => 'Development debugging toolbar',
            'spatie/laravel-permission' => 'Role & permission management',
            'laravel/sanctum' => 'API token authentication (simple)',
            'laravel/passport' => 'OAuth2 authentication system',
            'nunomaduro/collision' => 'Better CLI exception handler',
            'laravel/tinker' => 'REPL for Laravel (interactive shell)',
            'fakerphp/faker' => 'Fake data for testing and seeding',
            'phpunit/phpunit' => 'PHP unit testing framework',
            'laravel/telescope' => 'Powerful debugging/monitoring tool',
            'fruitcake/laravel-cors' => 'CORS header middleware for APIs',
        ];
    }

    /**
     * Returns a categorized array of Laravel authentication-related packages
     *
     * @return array{api: string[], backend: string[], frontend: string[], rbac: string[]}
     */
    private static function laravelAuth(): array
    {
        return [
            'api' => [
                'laravel/sanctum',
                'laravel/passport',
            ],
            'frontend' => [
                'laravel/breeze',
                'laravel/jetstream',
            ],
            'backend' => [
                'laravel/fortify',
            ],
            'rbac' => [
                'spatie/laravel-permission',
            ],
        ];
    }

    private static function symfonyTop10(): array
    {
        return [
            'symfony/maker-bundle' => 'Code scaffolding for Symfony apps',
            'symfony/debug-bundle' => 'Debugging tools in dev mode',
            'symfony/var-dumper' => 'Better `dump()` for dev inspection',
            'doctrine/doctrine-bundle' => 'Doctrine ORM integration',
            'doctrine/doctrine-fixtures-bundle' => 'Fixture system for test data',
            'phpunit/phpunit' => 'Test suite for PHP',
            'fakerphp/faker' => 'Fake data for fixtures',
            'symfony/web-profiler-bundle' => 'Toolbar and request profiler',
            'twig/twig' => 'Template engine',
            'symfony/http-client' => 'HTTP client abstraction',
        ];
    }

    public static function fetchDescription(string $package): ?string
    {
        $url = "https://packagist.org/packages/$package.json";

        try {
            $json = file_get_contents($url);
            $data = json_decode($json, true);

            return $data['package']['description'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function getAuthPackagesWithDescriptions(): array
    {
        $grouped = self::laravelAuth();
        $enriched = [];

        foreach ($grouped as $category => $packages) {
            foreach ($packages as $pkg) {
                $enriched[$category][$pkg] = Packagist::fetchDescription($pkg) ?? '(no description)';
            }
        }

        return $enriched;
    }
}
