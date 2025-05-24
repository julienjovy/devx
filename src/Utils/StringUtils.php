<?php

namespace App\Utils;

class StringUtils
{
    public static function padRight(string $text, int $width, string $pad = ' '): string
    {
        return str_pad($text, $width, $pad, STR_PAD_RIGHT);
    }

    public static function humanReadableSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' kB';
        }

        return $bytes.' B';
    }
}
