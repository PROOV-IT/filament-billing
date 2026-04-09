<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Actions\Quotes;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Proovit\Billing\Actions\Quotes\ConvertQuoteToInvoiceAction;
use Proovit\Billing\Enums\QuoteStatus;
use Proovit\Billing\Models\Quote;

final class QuoteRecordActions
{
    /**
     * @return array<int, Action>
     */
    public static function make(): array
    {
        return [
            ViewAction::make(),
            EditAction::make()
                ->visible(fn (Quote $record): bool => self::isEditable($record)),
            Action::make('convert_to_invoice')
                ->label(__('filament-billing::filament-billing.actions.convert_to_invoice'))
                ->icon('heroicon-o-arrow-right')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Quote $record): bool => self::canConvert($record))
                ->action(static function (Quote $record): void {
                    $invoice = app(ConvertQuoteToInvoiceAction::class)->handle($record);

                    Notification::make()
                        ->title(__('filament-billing::filament-billing.messages.quote_converted'))
                        ->body('Invoice '.$invoice->number.' has been created.')
                        ->success()
                        ->send();
                }),
            DeleteAction::make()
                ->visible(fn (Quote $record): bool => self::isDeletable($record)),
        ];
    }

    private static function isEditable(Quote $record): bool
    {
        return self::convertedInvoiceId($record) === null
            && in_array(self::statusValue($record), [QuoteStatus::Draft->value, QuoteStatus::Sent->value], true);
    }

    private static function isDeletable(Quote $record): bool
    {
        return self::convertedInvoiceId($record) === null
            && self::statusValue($record) !== QuoteStatus::Accepted->value;
    }

    private static function canConvert(Quote $record): bool
    {
        return self::convertedInvoiceId($record) === null
            && in_array(self::statusValue($record), [QuoteStatus::Draft->value, QuoteStatus::Sent->value, QuoteStatus::Accepted->value], true);
    }

    private static function statusValue(Quote $record): string
    {
        $status = $record->getAttribute('status');

        return $status instanceof QuoteStatus ? $status->value : (string) $status;
    }

    private static function convertedInvoiceId(Quote $record): ?int
    {
        $convertedInvoiceId = $record->getAttribute('converted_invoice_id');

        return $convertedInvoiceId === null ? null : (int) $convertedInvoiceId;
    }
}
