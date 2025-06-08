<?php

namespace App\Traits;

trait usePathTool
{
    public function basePath()
    {
        // il faut que cette fonction retourne le base path de devx
        return realpath(DEVX_BASE_PATH);
    }
}
