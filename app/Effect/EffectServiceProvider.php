<?php

namespace Fourum\Effect;

use Illuminate\Support\ServiceProvider;

class EffectServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Fourum\Effect\EffectRegistry', function ($app) {
            return new EffectRegistry([
                $app->make('Fourum\Effect\SuspendPosting')
            ]);
        });

        $this->app->bind('Fourum\Effect\EffectRepositoryInterface', 'Fourum\Effect\Eloquent\EffectRepository');
    }
}
