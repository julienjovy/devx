<?php

namespace App\Services\AliasMaker\Docker;

use App\Services\AliasMaker\AliasMakerInterface;
use App\Traits\usePathTool;
use App\Utils\Path;

class Docker implements AliasMakerInterface
{

    public static string $name = "docker";
    use usePathTool;

    public static function generateAliasFile(): void
    {
        $home = getenv('HOME') ?: getenv('USERPROFILE');
        if (! $home) {
            throw new \RuntimeException('Unable to determine the home directory');
        }

        $aliasFile = $home.'/.devx_docker_aliases';
        $resourceFile = Path::resourcePath('.docker_aliases.sh', 'aliases');

        if (! file_exists($aliasFile)) {
            copy($resourceFile, $aliasFile);
        }
    }
}
