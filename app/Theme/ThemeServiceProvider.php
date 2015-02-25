<?php

namespace Fourum\Theme;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Theme::class, Theme::class);
        $this->app->alias(Theme::class, 'theme');
    }
}