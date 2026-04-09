<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Proovit\Billing\Actions\Invoices\EnsureInvoicePdfStoredAction;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource;

final class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('regenerate_pdf')
                ->label(__('filament-billing::filament-billing.actions.regenerate_pdf'))
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->action(function (): void {
                    /** @var Invoice $invoice */
                    $invoice = $this->record;

                    $render = app(EnsureInvoicePdfStoredAction::class)->handle($invoice);

                    Notification::make()
                        ->success()
                        ->title(__('filament-billing::filament-billing.messages.invoice_pdf_regenerated'))
                        ->body($render->path ?? '')
                        ->send();
                }),
        ];
    }
}
