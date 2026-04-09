<?php

declare(strict_types=1);

use Proovit\FilamentBilling\Resources\CompanyResource;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;
use Proovit\FilamentBilling\Resources\PaymentResource;
use Proovit\FilamentBilling\Resources\ProductResource;
use Proovit\FilamentBilling\Resources\TaxRateResource;

it('exposes page-based CRUD routes for the manage-only resources', function (): void {
    expect(array_keys(CompanyResource::getPages()))->toBe(['index', 'create', 'view', 'edit']);
    expect(array_keys(ProductResource::getPages()))->toBe(['index', 'create', 'view', 'edit']);
    expect(array_keys(InvoiceSeriesResource::getPages()))->toBe(['index', 'create', 'view', 'edit']);
    expect(array_keys(PaymentResource::getPages()))->toBe(['index', 'create', 'view', 'edit']);
    expect(array_keys(TaxRateResource::getPages()))->toBe(['index', 'create', 'view', 'edit']);
});
