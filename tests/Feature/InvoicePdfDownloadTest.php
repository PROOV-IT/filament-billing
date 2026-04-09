<?php

declare(strict_types=1);

use Proovit\Billing\Models\Invoice;

it('downloads an invoice pdf from the admin route', function (): void {
    $invoice = Invoice::factory()->create([
        'number' => 'INV-2026-0001',
    ]);

    Invoice::query()
        ->whereKey($invoice->getKey())
        ->update([
            'currency' => 'EUR',
            'subtotal_amount' => '0.00',
            'tax_amount' => '0.00',
            'total_amount' => '0.00',
        ]);

    $invoice = $invoice->fresh();

    expect($invoice->currency)->toBe('EUR');

    /** @phpstan-ignore-next-line */
    $response = $this->withoutMiddleware()
        ->get(route('filament-billing.invoices.download-pdf', ['record' => $invoice]))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');

    expect($response->headers->get('Content-Disposition'))->toContain('attachment;');
    expect($response->headers->get('Content-Disposition'))->toContain('invoice-');
    expect($response->headers->get('Content-Disposition'))->toContain('.pdf');
});
