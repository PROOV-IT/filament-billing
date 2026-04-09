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
     *     recent_invoices: array<int, array<string, string|null>>
     * }
     */
    public function make(): array
    {
        $recentLimit = (int) config('filament-billing.dashboard.recent_invoices_limit', 5);

        $stats = [
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

        $recentInvoices = Collection::make(
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

        return [
            'stats' => $stats,
            'recent_invoices' => $recentInvoices,
        ];
    }
}
