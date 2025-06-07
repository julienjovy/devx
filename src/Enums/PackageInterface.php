<?php

namespace App\Enums;

interface PackageInterface
{
    public static function findByToolName(string $toolName): ?PackageInterface;

    public function label(): string;

    public function description(): string;

    public static function get(string $packageName): ?PackageInterface;

    public static function tryFromName(string $name): ?PackageInterface;
}
