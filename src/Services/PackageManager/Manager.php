<?php

namespace App\Services\PackageManager;

use App\Services\PackageManager\Chocolatey\ChocolateyManager;
use App\Services\PackageManager\Winget\WingetManager;

class Manager
{
    public static function resolve(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            if (ChocolateyManager::isAvailable()) {
                return ChocolateyManager::class;
            }

            if (WingetManager::isAvailable()) {
                return WingetManager::class;
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
