<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Actions\Invoices;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Proovit\Billing\Actions\Invoices\EnsureInvoicePdfStoredAction;
use Proovit\Billing\Models\Invoice;

final class InvoicePdfActions
{
    public static function regenerateHeaderAction(Invoice $record): Action
    {
        return Action::make('regenerate_pdf')
            ->label(__('filament-billing::filament-billing.actions.regenerate_pdf'))
            ->icon('heroicon-o-arrow-path')
            ->requiresConfirmation()
            ->action(static function () use ($record): void {
                $render = app(EnsureInvoicePdfStoredAction::class)->handle($record);

                Notification::make()
                    ->success()
                    ->title(__('filament-billing::filament-billing.messages.invoice_pdf_regenerated'))
                    ->body($render->path ?? '')
                    ->send();
            });
    }

    public static function downloadHeaderAction(Invoice $record): Action
    {
        return Action::make('download_pdf')
            ->label(__('filament-billing::filament-billing.actions.download_pdf'))
            ->icon('heroicon-o-arrow-down-tray')
            ->url(static fn (): string => self::downloadUrl($record));
    }

    public static function downloadTableAction(): Action
    {
        return Action::make('download_pdf')
            ->label(__('filament-billing::filament-billing.actions.download_pdf'))
            ->icon('heroicon-o-arrow-down-tray')
            ->url(static fn (Invoice $record): string => self::downloadUrl($record));
    }

    /**
     * @return array<int, Action>
     */
    public static function headerActions(Invoice $record): array
    {
        return [
            self::regenerateHeaderAction($record),
            self::downloadHeaderAction($record),
        ];
    }

    public static function downloadUrl(Invoice $record): string
    {
        return route('filament-billing.invoices.download-pdf', ['record' => $record->getRouteKey()]);
    }
}
