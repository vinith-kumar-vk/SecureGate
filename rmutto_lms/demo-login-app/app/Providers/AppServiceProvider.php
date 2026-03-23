<?php

namespace App\Providers;

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
        // Load language configuration
        config(['app.supported_locales' => config('languages.supported')]);
        config(['app.locale' => config('languages.default')]);
        config(['app.fallback_locale' => config('languages.fallback')]);
    }
}
