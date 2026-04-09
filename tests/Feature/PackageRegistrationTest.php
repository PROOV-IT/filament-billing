<?php

declare(strict_types=1);

use Proovit\FilamentBilling\FilamentBillingPlugin;
use Proovit\FilamentBilling\Support\BillingOverviewMetrics;

it('exposes the expected plugin id', function (): void {
    expect(FilamentBillingPlugin::make()->getId())->toBe('proovit-billing');
});

it('builds a billing overview payload', function (): void {
    $metrics = app(BillingOverviewMetrics::class)->make();

    expect($metrics)->toHaveKeys(['stats', 'recent_invoices']);
    expect($metrics['stats'])->toHaveCount(5);
    expect($metrics['recent_invoices'])->toBeArray();
});
