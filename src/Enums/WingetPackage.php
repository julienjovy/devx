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
            self::Git => 'Distributed version control system',
            self::NodeJS => 'JavaScript runtime environment (includes npm/yarn)',
            self::VSCode => 'Modern code editor',
            self::WindowsTerminal => 'Modern multi-shell terminal',
            self::Zip7 => 'Compression and extraction tool',
            self::Postman => 'REST API testing tool',
            self::OhMyPosh => 'Custom prompt theme engine for PowerShell/Terminal',
            self::FiraCode => 'Font with ligatures & icons for developers',
            self::Python => 'Scripting and automation language',
            self::GitHubCLI => 'Command-line interface for GitHub',
            self::Docker => 'Containerization platform for local development',
            self::Insomnia => 'Lightweight alternative to Postman for API testing',
            self::Neovim => 'Terminal-based text editor for power users',
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
        };
    }
}
