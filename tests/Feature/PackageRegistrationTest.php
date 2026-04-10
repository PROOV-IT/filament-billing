<?php

declare(strict_types=1);

use Proovit\FilamentBilling\FilamentBillingPlugin;
use Proovit\FilamentBilling\Pages\BillingDocumentation;
use Proovit\FilamentBilling\Resources\CompanyResource;
use Proovit\FilamentBilling\Resources\InvoiceResource;
use Proovit\FilamentBilling\Support\BillingOverviewMetrics;
use Proovit\FilamentBilling\Widgets\BillingStatsWidget;

it('exposes the expected plugin id', function (): void {
    expect(FilamentBillingPlugin::make()->getId())->toBe('proovit-billing');
});

it('builds a billing overview payload', function (): void {
    $metrics = app(BillingOverviewMetrics::class)->make();

    expect($metrics)->toHaveKeys(['stats', 'recent_invoices', 'recent_quotes']);
    expect($metrics['stats'])->toHaveCount(5);
    expect($metrics['recent_invoices'])->toBeArray();
    expect($metrics['recent_quotes'])->toBeArray();
});

it('exposes the expected filament classes', function (): void {
    expect(class_exists(CompanyResource::class))->toBeTrue();
    expect(class_exists(InvoiceResource::class))->toBeTrue();
    expect(class_exists(BillingDocumentation::class))->toBeTrue();
    expect(class_exists(BillingStatsWidget::class))->toBeTrue();
});
