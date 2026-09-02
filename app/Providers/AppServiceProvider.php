<?php

namespace App\Providers;

use App\Services\SettingsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Shared with every view (shop, admin, auth...) so any page can read
        // $settings without each controller passing it explicitly.
        View::composer('*', fn ($view) => $view->with('settings', app(SettingsService::class)->current()));
    }
}
