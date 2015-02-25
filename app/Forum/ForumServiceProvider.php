<?php

namespace Fourum\Forum;

use Fourum\Forum\Eloquent\ForumRepository;
use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ForumRepositoryInterface::class, function ($app) {
            return $app->make(ForumRepository::class);
        });
    }
}