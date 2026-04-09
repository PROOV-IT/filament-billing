<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Http\Controllers\Invoices;

use Proovit\Billing\Actions\Invoices\DownloadInvoicePdfAction;
use Proovit\Billing\Models\Invoice;
use Symfony\Component\HttpFoundation\Response;

final class DownloadInvoicePdfController
{
    public function __invoke(Invoice $record): Response
    {
        $record->loadMissing('company');

        $record->forceFill([
            'currency' => filled($record->getAttribute('currency'))
                ? $record->getAttribute('currency')
                : ($record->company?->getAttribute('default_currency') ?? 'EUR'),
            'subtotal_amount' => filled($record->getAttribute('subtotal_amount')) ? $record->getAttribute('subtotal_amount') : '0.00',
            'tax_amount' => filled($record->getAttribute('tax_amount')) ? $record->getAttribute('tax_amount') : '0.00',
            'total_amount' => filled($record->getAttribute('total_amount')) ? $record->getAttribute('total_amount') : '0.00',
        ]);

        return app(DownloadInvoicePdfAction::class)->handle($record);
    }
}
