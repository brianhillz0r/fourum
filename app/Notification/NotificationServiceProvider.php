<?php

namespace Fourum\Notification;

use Fourum\Notification\Eloquent\NotificationRepository;
use Fourum\Notification\Type\Eloquent\TypeRepository;
use Fourum\Notification\Type\TypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $types = $this->app->make(TypeRepositoryInterface::class);

        if (! $types->hasType(Mention::TYPE)) {
            $types->createAndSave(['name' => Mention::TYPE]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationRepositoryInterface::class, function ($app) {
            return $app->make(NotificationRepository::class);
        });

        $this->app->singleton('Fourum\Notification\NotificationFactory', 'Fourum\Notification\NotificationFactory');

        $this->app->bind(TypeRepositoryInterface::class, function ($app) {
            return $app->make(TypeRepository::class);
        });
    }
}