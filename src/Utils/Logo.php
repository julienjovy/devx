<?php

namespace App\Utils;

use Symfony\Component\Console\Style\SymfonyStyle;

class Logo
{
    public static function render(SymfonyStyle $io, string $subtitle): void
    {
        $io->newLine();
        $io->writeln("\033[38;5;46m██████╗ ███████╗██╗   ██╗██╗  ██╗\033[0m");
        $io->writeln("\033[38;5;46m██╔══██╗██╔════╝██║   ██║╚██╗██╔╝\033[0m");
        $io->writeln("\033[38;5;46m██║  ██║█████╗  ██║   ██║ ╚███╔╝\033[0m");
        $io->writeln("\033[38;5;46m██║  ██║██╔══╝  ╚██╗ ██╔╝ ██╔██╗\033[0m");
        $io->writeln("\033[38;5;46m██████╔╝███████╗ ╚████╔╝ ██╔╝ ██╗\033[0m");
        $io->writeln("\033[38;5;46m██████╔╝███████╗ ╚████╔╝ ██╔╝ ██╗\033[0m");
        $io->writeln("\033[38;5;46m╚═════╝ ╚══════╝  ╚═══╝  ╚═╝  ╚═╝\033[0m");
        $io->title(self::centerSubtitle($subtitle, 33));
    }

    public static function centerSubtitle($text, $size)
    {
        return str_pad($text, $size, ' ', STR_PAD_BOTH);
    }
}
