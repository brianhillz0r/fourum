<?php

namespace Fourum\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        dd($this->app->make('request')->route());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}