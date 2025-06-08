<?php

namespace App\Enums;

enum ComposerPackage: string implements PackageInterface
{
    case Laravel = 'laravel/laravel';
    case SymfonyConsole = 'symfony/console';
    case GuzzleHttp = 'guzzlehttp/guzzle';
    case PHPUnit = 'phpunit/phpunit';
    case Monolog = 'monolog/monolog';
    case DoctrineORM = 'doctrine/orm';
    case Faker = 'fzaninotto/faker';
    case Carbon = 'nesbot/carbon';
    case PHPMailer = 'phpmailer/phpmailer';
    case SwiftMailer = 'swiftmailer/swiftmailer';
    case Twig = 'twig/twig';
    case PHPSpec = 'phpspec/phpspec';
    case PsySH = 'psy/psysh';

    public function label(): string
    {
        return match ($this) {
            self::Laravel => 'Laravel Framework',
            self::SymfonyConsole => 'Symfony Console Component',
            self::GuzzleHttp => 'Guzzle HTTP Client',
            self::PHPUnit => 'PHPUnit Testing Framework',
            self::Monolog => 'Logging library',
            self::DoctrineORM => 'Doctrine ORM',
            self::Faker => 'Faker Data Generator',
            self::Carbon => 'DateTime library',
            self::PHPMailer => 'PHPMailer',
            self::SwiftMailer => 'SwiftMailer',
            self::Twig => 'Twig Templating Engine',
            self::PHPSpec => 'PHPSpec Testing Tool',
            self::PsySH => 'PHP REPL Shell',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Laravel => 'Popular PHP framework for web artisans',
            self::SymfonyConsole => 'Tools to create command-line commands',
            self::GuzzleHttp => 'PHP HTTP client for sending requests',
            self::PHPUnit => 'Unit testing framework for PHP',
            self::Monolog => 'Logging library for PHP applications',
            self::DoctrineORM => 'Object Relational Mapper for PHP',
            self::Faker => 'Generates fake data for testing',
            self::Carbon => 'Simple API extension for DateTime',
            self::PHPMailer => 'Full-featured email creation and transfer',
            self::SwiftMailer => 'Powerful component for sending emails',
            self::Twig => 'Flexible, fast, and secure template engine',
            self::PHPSpec => 'Behavior-driven development framework',
            self::PsySH => 'Interactive shell for PHP',
        };
    }

    public static function get(string $packageName): ?self
    {
        return self::tryFromName($packageName);
    }

    public static function tryFromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }

    public static function findByToolName(string $toolName): ?self
    {
        return match (strtolower($toolName)) {
            'laravel' => self::Laravel,
            'symfony-console' => self::SymfonyConsole,
            'guzzle' => self::GuzzleHttp,
            'phpunit' => self::PHPUnit,
            'monolog' => self::Monolog,
            'doctrine' => self::DoctrineORM,
            'faker' => self::Faker,
            'carbon' => self::Carbon,
            'phpmailer' => self::PHPMailer,
            'swiftmailer' => self::SwiftMailer,
            'twig' => self::Twig,
            'phpspec' => self::PHPSpec,
            'psysh' => self::PsySH,
            default => null,
        };
    }
}
