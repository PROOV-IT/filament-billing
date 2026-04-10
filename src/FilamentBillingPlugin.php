<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Proovit\FilamentBilling\Pages\BillingSettings;
use Proovit\FilamentBilling\Resources\CompanyResource;
use Proovit\FilamentBilling\Resources\CreditNoteResource;
use Proovit\FilamentBilling\Resources\CustomerResource;
use Proovit\FilamentBilling\Resources\InvoiceResource;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;
use Proovit\FilamentBilling\Resources\PaymentResource;
use Proovit\FilamentBilling\Resources\ProductResource;
use Proovit\FilamentBilling\Resources\QuoteResource;
use Proovit\FilamentBilling\Resources\TaxRateResource;
use Proovit\FilamentBilling\Support\BillingSettingsRepository;
use Proovit\FilamentBilling\Widgets\BillingStatsWidget;
use Proovit\FilamentBilling\Widgets\RecentInvoicesWidget;
use Proovit\FilamentBilling\Widgets\RecentQuotesWidget;

final class FilamentBillingPlugin implements Plugin
{
    protected bool $dashboardEnabled;

    public function __construct()
    {
        $settings = app(BillingSettingsRepository::class)->all();
        $this->dashboardEnabled = (bool) data_get($settings, 'dashboard.enabled', config('filament-billing.dashboard.enabled', true));
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
        $panel->resources([
            CompanyResource::class,
            CreditNoteResource::class,
            CustomerResource::class,
            InvoiceResource::class,
            InvoiceSeriesResource::class,
            PaymentResource::class,
            ProductResource::class,
            QuoteResource::class,
            TaxRateResource::class,
        ]);

        $panel->pages([
            BillingSettings::class,
        ]);

        if ($this->dashboardEnabled) {
            $panel->widgets([
                BillingStatsWidget::class,
                RecentInvoicesWidget::class,
                RecentQuotesWidget::class,
            ]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
