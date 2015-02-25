<?php

namespace Fourum\Thread;

use Fourum\Thread\Eloquent\ThreadRepository;
use Illuminate\Support\ServiceProvider;

class ThreadServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ThreadRepositoryInterface::class, function ($app) {
            return $app->make(ThreadRepository::class);
        });
    }
}