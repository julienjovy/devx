<?php

namespace App\Utils;

class Path
{
    public static function basePath(): string
    {
        return dirname(__DIR__, 2);
    }

    public static function resourcePath(string $filestring, $folder = ''): string
    {
        return self::basePath()
            .'/resources'
            .($folder ? '/'.ltrim($folder, '/') : '')
            .'/'.ltrim($filestring, '/');
    }
}
