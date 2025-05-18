<?php

namespace App\Utils;

class Packagist
{
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
}
