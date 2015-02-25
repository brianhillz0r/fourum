<?php

namespace Fourum\Rule;

use Fourum\Rule\Eloquent\RuleRepository;
use Illuminate\Support\ServiceProvider;

class RuleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RuleRepositoryInterface::class, function ($app) {
            return $app->make(RuleRepository::class);
        });
    }
}