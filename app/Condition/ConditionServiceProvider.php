<?php

namespace Fourum\Condition;

use Illuminate\Support\ServiceProvider;

class ConditionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConditionRegistry::class, function ($app) {
            return new ConditionRegistry();
        });
    }
}