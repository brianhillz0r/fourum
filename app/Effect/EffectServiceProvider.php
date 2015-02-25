<?php

namespace Fourum\Effect;

use Illuminate\Support\ServiceProvider;

class EffectServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Fourum\Effect\EffectRegistry', function ($app) {
            return new EffectRegistry([]);
        });
    }
}
