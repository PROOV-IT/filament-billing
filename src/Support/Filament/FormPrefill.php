<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament;

use Filament\Schemas\Components\Utilities\Set;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\Customer;
use Proovit\Billing\Models\Invoice;
use Proovit\Billing\Models\InvoiceSeries;

final class FormPrefill
{
    public static function companyCurrency(Set $set, mixed $state, string $field = 'currency'): void
    {
        $company = self::company($state);

        if (! $company instanceof Company) {
            return;
        }

        $currency = $company->getAttribute('default_currency');

        if (blank($currency)) {
            return;
        }

        $set($field, (string) $currency);
    }

    public static function companyDefaults(Set $set, mixed $state, string $currencyField = 'currency', string $establishmentField = 'establishment_id'): void
    {
        self::companyCurrency($set, $state, $currencyField);

        $company = self::company($state);

        if (! $company instanceof Company) {
            return;
        }

        $defaultEstablishmentId = $company->defaultEstablishment?->getKey() ?? $company->establishments()->oldest('id')->value('id');

        if ($defaultEstablishmentId) {
            $set($establishmentField, $defaultEstablishmentId);
        }
    }

    public static function companySeriesDefaults(Set $set, mixed $state): void
    {
        $company = self::company($state);

        if (! $company instanceof Company) {
            return;
        }

        $defaultEstablishmentId = $company->defaultEstablishment?->getKey() ?? $company->establishments()->oldest('id')->value('id');

        if ($defaultEstablishmentId) {
            $set('establishment_id', $defaultEstablishmentId);
        }

        if (filled($company->getAttribute('invoice_prefix'))) {
            $set('prefix', (string) $company->getAttribute('invoice_prefix'));
        }

        if (filled($company->getAttribute('invoice_sequence_pattern'))) {
            $set('pattern', (string) $company->getAttribute('invoice_sequence_pattern'));
        }
    }

    public static function customerDefaults(Set $set, mixed $state, string $currencyField = 'currency', string $companyField = 'company_id', ?string $establishmentField = null): void
    {
        $customer = self::customer($state);

        if (! $customer instanceof Customer) {
            return;
        }

        if ($customer->company instanceof Company) {
            $set($companyField, $customer->company->getKey());
            self::companyCurrency($set, $customer->company->getKey(), $currencyField);

            if ($establishmentField !== null) {
                self::companyDefaults($set, $customer->company->getKey(), $currencyField, $establishmentField);
            }
        }
    }

    public static function seriesDefaults(Set $set, mixed $state): void
    {
        $series = self::series($state);

        if (! $series instanceof InvoiceSeries) {
            return;
        }

        if ($series->company instanceof Company) {
            $set('company_id', $series->company->getKey());
            self::companyDefaults($set, $series->company->getKey());
        }

        if ($series->establishment) {
            $set('establishment_id', $series->establishment->getKey());
        }

        $documentType = $series->getAttribute('document_type');

        if ($documentType instanceof InvoiceType) {
            $set('document_type', $documentType->value);
        }
    }

    public static function invoiceDefaults(Set $set, mixed $state): void
    {
        $invoice = self::invoice($state);

        if (! $invoice instanceof Invoice) {
            return;
        }

        if ($invoice->company instanceof Company) {
            $set('company_id', $invoice->company->getKey());
            self::companyDefaults($set, $invoice->company->getKey());
        }

        if ($invoice->customer instanceof Customer) {
            $set('customer_id', $invoice->customer->getKey());
        }

        if ($invoice->series) {
            $set('invoice_series_id', $invoice->series->getKey());
        }

        if (filled($invoice->currency)) {
            $set('currency', (string) $invoice->currency);
        }
    }

    public static function quoteDefaults(Set $set, mixed $state): void
    {
        $invoice = self::invoice($state);

        if (! $invoice instanceof Invoice) {
            return;
        }

        if ($invoice->company instanceof Company) {
            $set('company_id', $invoice->company->getKey());
            self::companyCurrency($set, $invoice->company->getKey());
        }

        if ($invoice->customer instanceof Customer) {
            $set('customer_id', $invoice->customer->getKey());
        }

        if (filled($invoice->currency)) {
            $set('currency', (string) $invoice->currency);
        }
    }

    public static function creditNoteDefaults(Set $set, mixed $state): void
    {
        $invoice = self::invoice($state);

        if (! $invoice instanceof Invoice) {
            return;
        }

        if ($invoice->company instanceof Company) {
            $set('company_id', $invoice->company->getKey());
            self::companyCurrency($set, $invoice->company->getKey());
        }

        if (filled($invoice->currency)) {
            $set('currency', (string) $invoice->currency);
        }
    }

    public static function paymentFromInvoice(Set $set, mixed $state): void
    {
        $invoice = self::invoice($state);

        if (! $invoice instanceof Invoice) {
            return;
        }

        if ($invoice->company instanceof Company) {
            $set('company_id', $invoice->company->getKey());
            self::companyCurrency($set, $invoice->company->getKey());
        }

        if ($invoice->customer instanceof Customer) {
            $set('customer_id', $invoice->customer->getKey());
        }

        if (filled($invoice->currency)) {
            $set('currency', (string) $invoice->currency);
        }

        $paidAmount = (float) $invoice->payments()->sum('amount');
        $invoiceTotal = (float) ($invoice->getAttribute('total_amount') ?? 0);
        $outstanding = max(0, $invoiceTotal - $paidAmount);

        if ($outstanding > 0) {
            $set('amount', number_format($outstanding, 2, '.', ''));
        }
    }

    private static function company(mixed $state): ?Company
    {
        if (blank($state)) {
            return null;
        }

        return Company::query()->with(['defaultEstablishment', 'establishments'])->find($state);
    }

    private static function series(mixed $state): ?InvoiceSeries
    {
        if (blank($state)) {
            return null;
        }

        return InvoiceSeries::query()->with(['company.defaultEstablishment', 'establishment'])->find($state);
    }

    private static function invoice(mixed $state): ?Invoice
    {
        if (blank($state)) {
            return null;
        }

        return Invoice::query()->with(['company.defaultEstablishment', 'customer', 'series', 'payments'])->find($state);
    }

    private static function customer(mixed $state): ?Customer
    {
        if (blank($state)) {
            return null;
        }

        return Customer::query()->with(['company'])->find($state);
    }
}
