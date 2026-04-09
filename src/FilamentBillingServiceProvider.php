<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling;

use Illuminate\Support\ServiceProvider;

final class FilamentBillingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-billing.php', 'filament-billing');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-billing');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/filament-billing.php' => config_path('filament-billing.php'),
        ], 'filament-billing-config');

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path('vendor/filament-billing'),
        ], 'filament-billing-translations');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
