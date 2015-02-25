<?php

namespace Fourum\View;

use Illuminate\View\ViewFinderInterface;

class ViewServiceProvider extends \Illuminate\View\ViewServiceProvider
{
    /**
     * Ovveride registerViewFinder to use Fourum\View\FileViewFinder
     */
    public function registerViewFinder()
    {
        $this->app['view.finder'] = $this->app->share(function($app)
        {
            $paths = $app['config']['view.paths'];

            return new FileViewFinder($app['files'], $paths);
        });

        $this->app[FileViewFinder::class] = $this->app->share(function($app) {
            return $app['view.finder'];
        });

        $this->app[ViewFinderInterface::class] = $this->app->share(function($app) {
            return $app['view.finder'];
        });
    }
}