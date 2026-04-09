<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling;

use Illuminate\Support\ServiceProvider;

final class FilamentBillingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-billing.php', 'filament-billing');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-billing');

        $this->publishes([
            __DIR__.'/../config/filament-billing.php' => config_path('filament-billing.php'),
        ], 'filament-billing-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/filament-billing'),
        ], 'filament-billing-views');
    }
}
