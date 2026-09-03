<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\CartService;
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
        $this->app->singleton(CartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Shared with every view (shop, admin, auth...) so any page can read
        // $settings without each controller passing it explicitly.
        View::composer('*', fn ($view) => $view->with('settings', app(SettingsService::class)->current()));

        // The cart badge and the "Boutique" dropdown's category list both live in the header
        // partial, included on every shop page.
        View::composer('partials.shop.header', function ($view) {
            $view->with('cartCount', app(CartService::class)->count());
            $view->with('navCategories', Category::active()->whereNull('parent_id')->ordered()->get());
        });
    }
}
