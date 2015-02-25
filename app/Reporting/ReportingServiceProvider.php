<?php

namespace Fourum\Reporting;

use Fourum\Reporting\Eloquent\ReportRepository;
use Illuminate\Support\ServiceProvider;

class ReportingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReportRepositoryInterface::class, function ($app) {
            return $app->make(ReportRepository::class);
        });
    }
}