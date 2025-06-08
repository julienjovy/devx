<?php

namespace App\Services\PackageManager;

use App\Services\PackageManager\Chocolatey\ChocolateyService;
use App\Services\PackageManager\Winget\WingetService;

class Manager
{
    public static function resolve(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            if (ChocolateyService::isAvailable()) {
                return ChocolateyService::class;
            }

            if (WingetService::isAvailable()) {
                return WingetService::class;
            }
        }

        if (PHP_OS_FAMILY === 'Darwin') {
            // MacOs
        }

        if (PHP_OS_FAMILY === 'Linux') {

        }
        throw new \RuntimeException('No supported package manager found.');
    }
}
