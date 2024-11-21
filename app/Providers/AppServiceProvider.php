<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WeatherApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(WeatherApiService::class, function ($app) {
            return new WeatherApiService(
                config('weather.api_url'),
                config('weather.api_key')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
