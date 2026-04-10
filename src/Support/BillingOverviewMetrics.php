<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support;

use Illuminate\Support\Collection;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\Customer;
use Proovit\Billing\Models\Invoice;
use Proovit\Billing\Models\Payment;
use Proovit\Billing\Models\Quote;

final class BillingOverviewMetrics
{
    /**
     * @return array{
     *     stats: array<int, array{label: string, value: string, hint: string}>,
     *     recent_invoices: array<int, array<string, string|null>>,
     *     recent_quotes: array<int, array<string, string|null>>
     * }
     */
    public function make(): array
    {
        return [
            'stats' => $this->stats(),
            'recent_invoices' => $this->recentInvoices(),
            'recent_quotes' => $this->recentQuotes(),
        ];
    }

    /**
     * @return array<int, array{label: string, value: string, hint: string}>
     */
    public function stats(): array
    {
        return [
            [
                'label' => 'Companies',
                'value' => (string) Company::query()->count(),
                'hint' => 'Billing entities registered in the core.',
            ],
            [
                'label' => 'Customers',
                'value' => (string) Customer::query()->count(),
                'hint' => 'Customers ready for invoicing.',
            ],
            [
                'label' => 'Invoices',
                'value' => (string) Invoice::query()->count(),
                'hint' => 'All invoices in the current panel scope.',
            ],
            [
                'label' => 'Quotes',
                'value' => (string) Quote::query()->count(),
                'hint' => 'Open and converted quotations.',
            ],
            [
                'label' => 'Payments',
                'value' => (string) Payment::query()->count(),
                'hint' => 'Tracked payments and allocations.',
            ],
        ];
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    public function recentInvoices(): array
    {
        $recentLimit = (int) (app(BillingSettingsRepository::class)->all()['dashboard']['recent_invoices_limit'] ?? config('filament-billing.dashboard.recent_invoices_limit', 5));

        return Collection::make(
            Invoice::query()
                ->with(['customer', 'quote'])
                ->latest('created_at')
                ->limit($recentLimit)
                ->get()
        )->map(static function (Invoice $invoice): array {
            $status = $invoice->getAttribute('status');
            $documentType = $invoice->getAttribute('document_type');

            return [
                'number' => $invoice->number ?? 'Draft',
                'customer' => data_get($invoice, 'customer.legal_name')
                    ?? data_get($invoice, 'customer.full_name')
                    ?? 'Unknown customer',
                'status' => $status?->label() ?? 'Draft',
                'type' => $documentType?->label() ?? 'Invoice',
                'total' => number_format((float) $invoice->total_amount, 2, ',', ' ').' '.($invoice->currency ?? 'EUR'),
            ];
        })->all();
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    public function recentQuotes(): array
    {
        $recentLimit = (int) (app(BillingSettingsRepository::class)->all()['dashboard']['recent_quotes_limit'] ?? config('filament-billing.dashboard.recent_quotes_limit', 5));

        return Collection::make(
            Quote::query()
                ->with('customer')
                ->latest('created_at')
                ->limit($recentLimit)
                ->get()
        )->map(static function (Quote $quote): array {
            $status = $quote->getAttribute('status');

            return [
                'number' => $quote->number ?? 'Draft',
                'customer' => data_get($quote, 'customer.legal_name')
                    ?? data_get($quote, 'customer.full_name')
                    ?? 'Unknown customer',
                'status' => $status?->label() ?? 'Draft',
                'total' => number_format((float) $quote->total_amount, 2, ',', ' ').' '.($quote->currency ?? 'EUR'),
            ];
        })->all();
    }
}
