<?php

namespace App\Enums;

interface PackageInterface
{

    static function findByToolName(string $toolName): ?PackageInterface;

    public function label(): string;

    public function description(): string;

    public static function get(string $packageName): ?PackageInterface;

    static function tryFromName(string $name): ?PackageInterface;

}
