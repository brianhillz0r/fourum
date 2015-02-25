<?php

namespace Fourum\Tree;

use Fourum\Tree\Eloquent\NodeRepository;
use Illuminate\Support\ServiceProvider;

class TreeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NodeRepositoryInterface::class, function ($app) {
            return $app->make(NodeRepository::class);
        });
    }
}