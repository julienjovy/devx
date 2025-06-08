<?php

namespace App\Enums;

enum NpmPackage: string implements PackageInterface
{
    case Node = 'node';
    case Npm = 'npm';
    case Yarn = 'yarn';
    case Typescript = 'typescript';
    case React = 'react';
    case Vue = 'vue';
    case Angular = '@angular/core';
    case Express = 'express';
    case Jest = 'jest';
    case Webpack = 'webpack';
    case Babel = '@babel/core';
    case Eslint = 'eslint';
    case Prettier = 'prettier';

    public function label(): string
    {
        return match ($this) {
            self::Node => 'Node.js',
            self::Npm => 'npm',
            self::Yarn => 'Yarn',
            self::Typescript => 'TypeScript',
            self::React => 'React',
            self::Vue => 'Vue.js',
            self::Angular => 'Angular',
            self::Express => 'Express',
            self::Jest => 'Jest',
            self::Webpack => 'Webpack',
            self::Babel => 'Babel',
            self::Eslint => 'ESLint',
            self::Prettier => 'Prettier',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Node => 'JavaScript runtime environment',
            self::Npm => 'Node package manager',
            self::Yarn => 'Alternative JavaScript package manager',
            self::Typescript => 'Typed superset of JavaScript',
            self::React => 'JavaScript library for building user interfaces',
            self::Vue => 'Progressive JavaScript framework',
            self::Angular => 'Platform for building mobile and desktop web applications',
            self::Express => 'Fast, unopinionated, minimalist web framework for Node.js',
            self::Jest => 'JavaScript testing framework',
            self::Webpack => 'Static module bundler for JavaScript applications',
            self::Babel => 'JavaScript compiler',
            self::Eslint => 'Tool for identifying and reporting on patterns in JavaScript',
            self::Prettier => 'Opinionated code formatter',
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
            'node' => self::Node,
            'npm' => self::Npm,
            'yarn' => self::Yarn,
            'typescript' => self::Typescript,
            'react' => self::React,
            'vue' => self::Vue,
            'angular' => self::Angular,
            'express' => self::Express,
            'jest' => self::Jest,
            'webpack' => self::Webpack,
            'babel' => self::Babel,
            'eslint' => self::Eslint,
            'prettier' => self::Prettier,
            default => null,
        };
    }
}
