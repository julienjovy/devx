<?php

namespace App\Services\AliasMaker\Kubectl;

use App\Traits\usePathTool;
use App\Utils\Path;

class Kubectl
{
    use usePathTool;

    public static function generateAliasFile(): void
    {
        $home = getenv('HOME') ?: getenv('USERPROFILE');
        if (! $home) {
            throw new \RuntimeException('Unable to determine the home directory');
        }

        $aliasFile = $home.'/.devx_kubectl_aliases';
        $resourceFile = Path::resourcePath('.kubectl_aliases.sh', 'aliases');

        if (! file_exists($aliasFile)) {
            copy($resourceFile, $aliasFile);
        }
    }
}
