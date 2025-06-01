<?php

namespace App\Enums;

enum WingetPackage: string implements PackageInterface
{
    case Git = 'Git.Git';
    case NodeJS = 'OpenJS.NodeJS.LTS';
    case VSCode = 'Microsoft.VisualStudioCode';
    case WindowsTerminal = 'Microsoft.WindowsTerminal';
    case Zip7 = '7zip.7zip';
    case Postman = 'Postman.Postman';
    case OhMyPosh = 'JanDeDobbeleer.OhMyPosh';
    case FiraCode = 'NerdFonts.FiraCode';
    case Python = 'Python.Python.3';
    case GitHubCLI = 'GitHub.cli';
    case Docker = 'Docker.DockerDesktop';
    case Insomnia = 'Kong.Insomnia';
    case Neovim = 'Neovim.Neovim';

    public function label(): string
    {
        return match ($this) {
            self::Git => 'Git',
            self::NodeJS => 'Node.js LTS',
            self::VSCode => 'Visual Studio Code',
            self::WindowsTerminal => 'Windows Terminal',
            self::Zip7 => '7-Zip',
            self::Postman => 'Postman',
            self::OhMyPosh => 'Oh My Posh',
            self::FiraCode => 'Fira Code (Nerd Font)',
            self::Python => 'Python 3',
            self::GitHubCLI => 'GitHub CLI',
            self::Docker => 'Docker Desktop',
            self::Insomnia => 'Insomnia',
            self::Neovim => 'Neovim',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Git => 'Contrôle de version distribué',
            self::NodeJS => 'Runtime JavaScript + npm/yarn',
            self::VSCode => 'Éditeur de code moderne',
            self::WindowsTerminal => 'Terminal multi-shell moderne',
            self::Zip7 => 'Outil de compression/décompression',
            self::Postman => 'Testeur d’API REST',
            self::OhMyPosh => 'Custom prompt pour PowerShell/Terminal',
            self::FiraCode => 'Police avec ligatures & icônes pour devs',
            self::Python => 'Langage de script et d’automatisation',
            self::GitHubCLI => 'Interface GitHub en ligne de commande',
            self::Docker => 'Conteneurisation pour dev local',
            self::Insomnia => 'Alternative à Postman, légère et rapide',
            self::Neovim => 'Éditeur terminal ultra rapide pour puristes',
        };
    }

    public static function get(string $packageName): ?self
    {
        return self::tryFromName($packageName);
    }

    public static function tryFromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            print_r($case);
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }

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
}
