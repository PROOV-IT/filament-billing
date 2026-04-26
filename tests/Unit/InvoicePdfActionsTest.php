<?php

declare(strict_types=1);

use Filament\Actions\Action;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Support\Filament\Actions\Invoices\InvoicePdfActions;

it('returns the expected action types for page and table contexts', function (): void {
    $invoice = new Invoice;
    $invoice->setAttribute($invoice->getKeyName(), 'invoice-test');

    expect(InvoicePdfActions::downloadHeaderAction($invoice))->toBeInstanceOf(Action::class);
    expect(InvoicePdfActions::downloadTableAction())->toBeInstanceOf(Action::class);
});
