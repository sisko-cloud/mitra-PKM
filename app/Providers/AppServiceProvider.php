<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Force HTTPS on production (Vercel) to prevent mixed-content form actions
        if (config('app.env') === 'production' || isset($_ENV['VERCEL'])) {
            URL::forceScheme('https');
        }
    }
}
