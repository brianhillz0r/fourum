<?php

namespace Fourum\Group;

use Fourum\Group\Eloquent\GroupRepository;
use Illuminate\Support\ServiceProvider;

class GroupServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GroupRepositoryInterface::class, function ($app) {
            return $app->make(GroupRepository::class);
        });
    }
}