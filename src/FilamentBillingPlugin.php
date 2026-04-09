<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Proovit\FilamentBilling\Pages\BillingOverview;

final class FilamentBillingPlugin implements Plugin
{
    protected bool $dashboardEnabled;

    public function __construct()
    {
        $this->dashboardEnabled = (bool) config('filament-billing.dashboard.enabled', true);
    }

    public static function make(): static
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'proovit-billing';
    }

    public function dashboard(bool $condition = true): static
    {
        $this->dashboardEnabled = $condition;

        return $this;
    }

    public function register(Panel $panel): void
    {
        if (! $this->dashboardEnabled) {
            return;
        }

        $panel->pages([
            BillingOverview::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
