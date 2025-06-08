<?php

namespace App\Services\Infra\CLI;

class DockerCLI
{
    private string $aliasFilePath;

    private string $sourceAliasFile;

    public function __construct()
    {
        $home = getenv('HOME') ?: getenv('USERPROFILE');
        if (! $home) {
            throw new \RuntimeException('Unable to determine the home directory');
        }

        $this->aliasFilePath = $home.'/.devx_docker_aliases';
        $this->sourceAliasFile = __DIR__.'/../../resources/aliases/.docker_aliases.sh';

        if (file_exists($this->aliasFilePath)) {
            exit($this->aliasFilePath);
        }
    }
}
