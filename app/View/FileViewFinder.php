<?php

namespace Fourum\View;

class FileViewFinder extends \Illuminate\View\FileViewFinder
{
    /**
     * Method for overriding the $this->paths on
     * \Illuminate\View\FileViewFinder
     *
     * This is so Theme can inject the correct view
     * path on the fly.
     *
     * @param array $paths
     */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;
    }
}