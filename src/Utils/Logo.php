<?php

namespace App\Utils;

use Symfony\Component\Console\Style\SymfonyStyle;

class Logo
{
    public static function render(SymfonyStyle $io, string $subtile): void
    {
        $io->writeln("\033[38;5;46m██████╗ ███████╗██╗   ██╗██╗  ██╗\033[0m");
        $io->writeln("\033[38;5;46m██╔══██╗██╔════╝██║   ██║╚██╗██╔╝\033[0m");
        $io->writeln("\033[38;5;46m██║  ██║█████╗  ██║   ██║ ╚███╔╝\033[0m");
        $io->writeln("\033[38;5;46m██║  ██║██╔══╝  ╚██╗ ██╔╝ ██╔██╗\033[0m");
        $io->writeln("\033[38;5;46m██████╔╝███████╗ ╚████╔╝ ██╔╝ ██╗\033[0m");
        $io->writeln("\033[38;5;46m██████╔╝███████╗ ╚████╔╝ ██╔╝ ██╗\033[0m");
        $io->writeln("\033[38;5;46m╚═════╝ ╚══════╝  ╚═══╝  ╚═╝  ╚═╝\033[0m");
        $io->writeln("$subtile");
    }
}
