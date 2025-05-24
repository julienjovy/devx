<?php

use App\Utils\Shell;

it('can run doctor command', function () {
    $process = new Symfony\Component\Process\Process(['php', 'bin/devx', 'doctor', '--system']);
    $process->run();

    expect($process->isSuccessful())->toBeTrue();
    expect($process->getOutput())->toContain('System Tools');
});

it('detects php version', function () {
    $output = Shell::runVersionCommand('php -v');
    expect($output)->toBeString();
    expect($output)->toContain('PHP');
});
