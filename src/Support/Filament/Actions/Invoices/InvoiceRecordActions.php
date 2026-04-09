<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Actions\Invoices;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Proovit\Billing\Actions\Invoices\CreateCreditNoteFromInvoiceAction;
use Proovit\Billing\Actions\Invoices\FinalizeInvoiceAction;
use Proovit\Billing\Actions\Invoices\GenerateInvoiceShareLinkAction;
use Proovit\Billing\Actions\Invoices\RevokeInvoiceShareLinkAction;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Models\Invoice;

final class InvoiceRecordActions
{
    /**
     * @return array<int, Action>
     */
    public static function make(): array
    {
        return [
            ViewAction::make(),
            EditAction::make()
                ->visible(fn (Invoice $record): bool => self::isEditable($record)),
            Action::make('finalize')
                ->label('Finalize')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Invoice $record): bool => self::canFinalize($record))
                ->action(static function (Invoice $record): void {
                    app(FinalizeInvoiceAction::class)->handle($record);

                    Notification::make()
                        ->title('Invoice finalized')
                        ->success()
                        ->send();
                }),
            Action::make('generate_share_link')
                ->label('Generate share link')
                ->icon('heroicon-o-link')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn (Invoice $record): bool => self::canShare($record))
                ->action(static function (Invoice $record): void {
                    $url = app(GenerateInvoiceShareLinkAction::class)->handle($record, regenerate: true);

                    Notification::make()
                        ->title('Public share link ready')
                        ->body($url)
                        ->success()
                        ->send();
                }),
            Action::make('revoke_share_link')
                ->label('Revoke share link')
                ->icon('heroicon-o-link-slash')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn (Invoice $record): bool => filled($record->getAttribute('public_share_token')))
                ->action(static function (Invoice $record): void {
                    app(RevokeInvoiceShareLinkAction::class)->handle($record);

                    Notification::make()
                        ->title('Public share link revoked')
                        ->success()
                        ->send();
                }),
            Action::make('create_credit_note')
                ->label('Credit note')
                ->icon('heroicon-o-document-plus')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn (Invoice $record): bool => self::canCreditNote($record))
                ->action(static function (Invoice $record): void {
                    app(CreateCreditNoteFromInvoiceAction::class)->handle($record);

                    Notification::make()
                        ->title('Credit note created')
                        ->success()
                        ->send();
                }),
            DeleteAction::make()
                ->visible(fn (Invoice $record): bool => self::isDeletable($record)),
        ];
    }

    private static function isEditable(Invoice $record): bool
    {
        return in_array(self::statusValue($record), [InvoiceStatus::Draft->value, InvoiceStatus::Pending->value], true);
    }

    private static function isDeletable(Invoice $record): bool
    {
        return self::statusValue($record) === InvoiceStatus::Draft->value;
    }

    private static function canFinalize(Invoice $record): bool
    {
        return self::documentTypeValue($record) === InvoiceType::Invoice->value
            && in_array(self::statusValue($record), [InvoiceStatus::Draft->value, InvoiceStatus::Pending->value], true);
    }

    private static function canShare(Invoice $record): bool
    {
        return self::documentTypeValue($record) === InvoiceType::Invoice->value
            && (
                filled($record->getAttribute('public_share_token'))
                || in_array(self::statusValue($record), [InvoiceStatus::Finalized->value, InvoiceStatus::Paid->value], true)
            );
    }

    private static function canCreditNote(Invoice $record): bool
    {
        return self::documentTypeValue($record) === InvoiceType::Invoice->value
            && in_array(self::statusValue($record), [InvoiceStatus::Finalized->value, InvoiceStatus::Paid->value], true);
    }

    private static function statusValue(Invoice $record): string
    {
        $status = $record->getAttribute('status');

        return $status instanceof InvoiceStatus ? $status->value : (string) $status;
    }

    private static function documentTypeValue(Invoice $record): string
    {
        $documentType = $record->getAttribute('document_type');

        return $documentType instanceof InvoiceType ? $documentType->value : (string) $documentType;
    }
}
