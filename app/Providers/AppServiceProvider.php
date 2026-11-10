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
        // Vercel (dan hampir semua reverse proxy) meneruskan request sebagai HTTPS,
        // tetapi Laravel bisa menganggapnya HTTP. Paksa skema HTTPS di production
        // agar URL aset, redirect, dan link tidak menghasilkan mixed content.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
