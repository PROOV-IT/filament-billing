<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Database\Seeders;

use Illuminate\Database\Seeder;
use Proovit\Billing\Actions\Invoices\CreateDraftInvoiceAction;
use Proovit\Billing\Actions\Invoices\FinalizeInvoiceAction;
use Proovit\Billing\Actions\Invoices\GenerateInvoiceShareLinkAction;
use Proovit\Billing\Actions\Quotes\CreateQuoteAction;
use Proovit\Billing\Builders\Documents\InvoiceDocumentBuilder;
use Proovit\Billing\Database\Seeders\BillingDemoSeeder;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Enums\QuoteStatus;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\Customer;
use Proovit\Billing\Models\Invoice;
use Proovit\Billing\Models\InvoiceSeries;

final class FilamentBillingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BillingDemoSeeder::class);

        $company = Company::query()->firstOrFail();
        $customer = Customer::query()
            ->where('company_id', $company->id)
            ->where('reference', 'AGB-DEMO')
            ->first();

        if (! $customer instanceof Customer) {
            $customer = Customer::query()
                ->where('company_id', $company->id)
                ->latest('id')
                ->firstOrFail();
        }

        $draftInvoice = Invoice::query()
            ->where('company_id', $company->id)
            ->where('customer_id', $customer->id)
            ->where('document_type', InvoiceType::Invoice->value)
            ->where('status', InvoiceStatus::Draft->value)
            ->first();

        if ($draftInvoice instanceof Invoice) {
            $invoiceSeries = InvoiceSeries::query()
                ->where('company_id', $company->id)
                ->where('document_type', InvoiceType::Invoice->value)
                ->where('is_default', true)
                ->first();

            app(FinalizeInvoiceAction::class)->handle($draftInvoice, $invoiceSeries);
            app(GenerateInvoiceShareLinkAction::class)->handle($draftInvoice, now()->addDays(30), true);
        }

        app(CreateDraftInvoiceAction::class)->handle(
            InvoiceDocumentBuilder::make()
                ->withSeller($company->toSnapshot()->toArray())
                ->withCustomer($customer->toSnapshot()->toArray())
                ->withCurrency($company->default_currency ?? 'EUR')
                ->withNotes('Filament demo draft invoice used to showcase the finalize action.')
                ->addLines([
                    [
                        'description' => 'Panel onboarding',
                        'quantity' => '1',
                        'unit_price' => '220.00',
                        'tax_rate' => '20',
                    ],
                    [
                        'description' => 'Panel customization',
                        'quantity' => '1',
                        'unit_price' => '180.00',
                        'tax_rate' => '20',
                    ],
                ])
                ->toDraft(),
            $company->id,
            $customer->id,
        );

        $quote = app(CreateQuoteAction::class)->handle(
            InvoiceDocumentBuilder::make()
                ->withSeller($company->toSnapshot()->toArray())
                ->withCustomer($customer->toSnapshot()->toArray())
                ->withCurrency($company->default_currency ?? 'EUR')
                ->withNotes('Filament demo quote used to showcase the Convert to invoice action.')
                ->addLines([
                    [
                        'description' => 'Discovery workshop',
                        'quantity' => '1',
                        'unit_price' => '400.00',
                        'tax_rate' => '20',
                    ],
                    [
                        'description' => 'Implementation support',
                        'quantity' => '2',
                        'unit_price' => '150.00',
                        'tax_rate' => '20',
                    ],
                ])
                ->toDraft(),
            $company->id,
            $customer->id,
        );

        $quote->forceFill(['status' => QuoteStatus::Sent->value])->save();
    }
}
