<?php

namespace GameSpecU\Metrics;

use Illuminate\Support\ServiceProvider;


class MetricsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Metrics::class);
        Metrics::register($this->app);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
