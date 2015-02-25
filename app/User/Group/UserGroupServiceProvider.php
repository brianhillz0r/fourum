<?php

namespace Fourum\User\Group;

use Fourum\User\Group\Eloquent\GroupRepository;
use Illuminate\Support\ServiceProvider;

class UserGroupServiceProvider extends ServiceProvider
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