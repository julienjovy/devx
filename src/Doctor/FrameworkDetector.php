<?php

namespace App\Doctor;

class FrameworkDetector
{
    public static function detect(array $require): ?string
    {
        if (isset($require['laravel/framework'])) {
            return 'laravel';
        }

        if (isset($require['symfony/framework-bundle'])) {
            return 'symfony';
        }

        return null;
    }
}
