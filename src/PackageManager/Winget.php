<?php

use App\PackageManager\PackageManagerInterface;

class Winget implements PackageManagerInterface
{
    public function ensureInstalled(string $package) {}
    public function isAvailable() {}
    public function isPackageInstalled() {}
    public function install() {}
}
