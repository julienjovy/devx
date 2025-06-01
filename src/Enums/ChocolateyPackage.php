<?php

namespace App\Enums;

enum ChocolateyPackage: string implements PackageInterface
{
    case Git = 'git';
    case NodeJS = 'nodejs-lts';
    case VSCode = 'vscode';
    case WindowsTerminal = 'microsoft-windows-terminal';
    case Zip7 = '7zip';
    case Postman = 'postman';
    case OhMyPosh = 'oh-my-posh';
    case FiraCode = 'firacode';
    case Python = 'python';
    case GitHubCLI = 'gh';
    case Docker = 'docker-desktop';
    case Insomnia = 'insomnia-rest-api-client';
    case Neovim = 'neovim';

    public static function findByToolName(string $toolName): ?self
    {
        return match ($toolName) {
            'git' => self::Git,
            'node' => self::NodeJS,
            'vscode' => self::VSCode,
            'windows-terminal' => self::WindowsTerminal,
            '7zip' => self::Zip7,
            'postman' => self::Postman,
            'oh-my-posh' => self::OhMyPosh,
            'firacode' => self::FiraCode,
            'python' => self::Python,
            'github-cli' => self::GitHubCLI,
            'docker' => self::Docker,
            'insomnia' => self::Insomnia,
            'neovim' => self::Neovim,
            default => null,
        };
    }

    public function label(): string
    {
        // TODO: Implement label() method.
    }

    public function description(): string
    {
        // TODO: Implement description() method.
    }

    public static function get(string $packageName): ?PackageInterface
    {
        // TODO: Implement get() method.
    }

    static function tryFromName(string $name): ?PackageInterface
    {
        // TODO: Implement tryFromName() method.
    }
}
