<?php

declare(strict_types=1);

use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Enums\QuoteStatus;
use Proovit\Billing\Models\Invoice;
use Proovit\Billing\Models\Quote;
use Proovit\FilamentBilling\Database\Seeders\FilamentBillingDemoSeeder;
use Tests\TestCase;

it('seeds a filament-ready demo dataset', function (): void {
    /** @var TestCase $this */
    $this->artisan('db:seed', [
        '--class' => FilamentBillingDemoSeeder::class,
        '--force' => true,
    ])->assertExitCode(0);

    expect(Quote::query()->count())->toBeGreaterThanOrEqual(2);
    expect(Invoice::query()->count())->toBeGreaterThanOrEqual(2);
    expect(Quote::query()->whereNull('converted_invoice_id')->where('status', QuoteStatus::Sent->value)->exists())->toBeTrue();

    $finalizedInvoice = Invoice::query()
        ->where('document_type', InvoiceType::Invoice->value)
        ->where('status', InvoiceStatus::Finalized->value)
        ->whereNotNull('public_share_token')
        ->firstOrFail();

    expect(Invoice::query()->where('customer_id', $finalizedInvoice->getAttribute('customer_id'))->where('document_type', InvoiceType::Invoice->value)->where('status', InvoiceStatus::Draft->value)->exists())->toBeTrue();
});
