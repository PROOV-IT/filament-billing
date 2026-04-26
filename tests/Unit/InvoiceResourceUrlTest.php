<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Filament\FilamentManager;
use Filament\Panel;
use Illuminate\Support\Facades\Route;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource;

it('builds invoice view and edit urls with the record parameter', function (): void {
    app()->instance('filament', new FilamentManager());

    $panel = Panel::make()
        ->id('admin')
        ->path('admin')
        ->default();

    Filament::setCurrentPanel($panel);

    Route::name('filament.admin.')
        ->prefix('admin')
        ->group(static function () use ($panel): void {
            InvoiceResource::registerRoutes($panel);
        });

    $invoice = Invoice::factory()->create();

    expect(InvoiceResource::getUrl('view', ['record' => $invoice]))->toContain('/admin/billing/invoices/'.$invoice->getRouteKey());
    expect(InvoiceResource::getUrl('edit', ['record' => $invoice]))->toContain('/admin/billing/invoices/'.$invoice->getRouteKey().'/edit');
});
