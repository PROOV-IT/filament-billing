<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Pages;

use Filament\Pages\Page;
use Filament\Panel;
use Proovit\FilamentBilling\Support\BillingOverviewMetrics;

final class BillingOverview extends Page
{
    protected string $view = 'filament-billing::pages.billing-overview';

    protected static ?string $title = 'Billing Overview';

    protected static ?string $slug = 'billing-overview';

    /**
     * @var array{
     *     stats: array<int, array{label: string, value: string, hint: string}>,
     *     recent_invoices: array<int, array{number: string, customer: string, status: string, type: string, total: string}>
     * }
     */
    public array $overview = [
        'stats' => [],
        'recent_invoices' => [],
    ];

    public function mount(BillingOverviewMetrics $metrics): void
    {
        $this->overview = $metrics->make();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return (string) config('filament-billing.dashboard.slug', self::$slug ?? 'billing-overview');
    }

    public static function getNavigationLabel(): string
    {
        return (string) config('filament-billing.dashboard.navigation_label', 'Billing');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-billing.navigation_group', 'Billing');
    }
}
