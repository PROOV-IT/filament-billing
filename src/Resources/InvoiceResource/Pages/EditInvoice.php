<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource;
use Proovit\FilamentBilling\Support\Filament\Actions\Invoices\InvoicePdfActions;

final class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        /** @var Invoice $invoice */
        $invoice = $this->record;

        return [
            ViewAction::make('view')
                ->label(__('filament-billing::filament-billing.actions.view'))
                ->icon('heroicon-o-eye')
                ->url(fn (): string => static::getResource()::getUrl('view', ['record' => $this->getRecord()])),
            ...InvoicePdfActions::headerActions($invoice),
        ];
    }
}
