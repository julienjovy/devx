<?php

namespace App\Doctor;

class ProjectScanner
{
    /**
     * Check if a file exists.
     */
    public static function fileExists(string $file): bool
    {
        return file_exists($file);
    }

    /**
     * Check if a dir exists.
     */
    public static function dirExists(string $dir): bool
    {
        return is_dir($dir);
    }

    /**
     * Check if a path is writable.
     */
    public static function isWritable(string $path): bool
    {
        return is_writable($path);
    }
}
