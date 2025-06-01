<?php

namespace App\Utils;

use Symfony\Component\Process\Process;

class Shell
{
    /**
     * Run a shell command and return the first non-empty line of output.
     * Useful for version detection or simple command verification.
     */
    public static function runVersionCommand(string $command): ?string
    {
        $process = Process::fromShellCommandline($command);
        $process->run();

        $output = $process->getOutput().$process->getErrorOutput();
        $lines = preg_split("/(\r\n|\n|\r)/", $output);

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '') {
                return $line;
            }
        }

        return null;
    }

    public static function runCommand(string $command): string
    {
        $process = Process::fromShellCommandline($command);
        $process->run(function ($_, $buffer) {
            echo $buffer;
        });

        return $process->getOutput();
    }

    public static function runInstallCommand(string $command): string
    {
        $process = Process::fromShellCommandline($command);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (! $process->isSuccessful()) {
            $exitCode = $process->getExitCode();
            $error = $process->getErrorOutput();

            if (! $process->getStopSignal()) {
                throw new \RuntimeException('❌ Installation annulée : élévation refusée par l’utilisateur.');
            }

            throw new \RuntimeException("❌ Erreur durant l'installation : {$error}");
        }

        return $process->getOutput();
    }
}
