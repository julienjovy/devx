<?php

namespace App\Services\Infra\CLI;

class KubectlCLI
{
    private string $aliasFilePath;

    private string $sourceAliasFile;

    public function __construct()
    {
        $home = getenv('HOME') ?: getenv('USERPROFILE');
        if (! $home) {
            throw new \RuntimeException('Unable to determine the home directory');
        }

        $this->aliasFilePath = $home.'/.devx_kubectl_aliases';
        $this->sourceAliasFile = __DIR__.'/../../resources/aliases/.kubectl_aliases.sh';
    }
}
