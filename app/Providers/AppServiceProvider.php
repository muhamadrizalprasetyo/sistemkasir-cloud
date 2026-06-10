<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    public function boot()
{
    // Memaksa konfigurasi database dari environment
    if (env('DB_HOST')) {
        config(['b8qzjot1zfwr4phyfpud-mysql.services.clever-cloud.com' => env('DB_HOST')]);
        config(['b8qzjot1zfwr4phyfpud' => env('DB_DATABASE')]);
        config(['ulceioollmmzskje' => env('DB_USERNAME')]);
        config(['EfHO16CADIBpFMhSvC7R' => env('DB_PASSWORD')]);
        config(['3306' => env('DB_PORT', '3306')]);
    }
}
}