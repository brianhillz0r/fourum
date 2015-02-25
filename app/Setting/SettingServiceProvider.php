<?php

namespace Fourum\Setting;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Fourum\Setting\Filesystem\SettingRepository',
            'Fourum\Setting\Filesystem\SettingRepository'
        );

        $this->app->alias(Manager::class, 'settings');
    }
}