<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Quotes;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Actions\Quotes\ConvertQuoteToInvoiceAction;
use Proovit\Billing\Enums\QuoteStatus;
use Proovit\Billing\Models\Quote;
use Proovit\FilamentBilling\Resources\QuoteResource;

final class QuoteTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label(__('filament-billing::filament-billing.columns.number'))->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label(__('filament-billing::filament-billing.columns.customer'))->searchable()->sortable(),
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : __('filament-billing::filament-billing.statuses.draft')),
                TextColumn::make('issued_at')->label(__('filament-billing::filament-billing.columns.issued_at'))->date()->sortable()->toggleable(),
                TextColumn::make('total_amount')->label(__('filament-billing::filament-billing.columns.total'))->formatStateUsing(static fn ($state, Quote $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
            ])
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => QuoteResource::getUrl('create')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (Quote $record): string => QuoteResource::getUrl('view', ['record' => $record->getRouteKey()])),
                EditAction::make()
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (Quote $record): string => QuoteResource::getUrl('edit', ['record' => $record->getRouteKey()]))
                    ->visible(fn (Quote $record): bool => self::canEdit($record)),
                Action::make('convert_to_invoice')
                    ->label(__('filament-billing::filament-billing.actions.convert_to_invoice'))
                    ->icon('heroicon-o-arrow-right')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Quote $record): bool => self::canConvert($record))
                    ->action(static function (Quote $record): void {
                        app(ConvertQuoteToInvoiceAction::class)->handle($record);
                    }),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (Quote $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (Quote $record): bool => self::canDelete($record))
            ->defaultSort('created_at', 'desc');
    }

    private static function canEdit(Quote $record): bool
    {
        $status = $record->getAttribute('status');
        $statusValue = $status instanceof QuoteStatus ? $status->value : (string) $status;

        return $record->getAttribute('converted_invoice_id') === null
            && in_array($statusValue, [QuoteStatus::Draft->value, QuoteStatus::Sent->value], true);
    }

    private static function canDelete(Quote $record): bool
    {
        $status = $record->getAttribute('status');
        $statusValue = $status instanceof QuoteStatus ? $status->value : (string) $status;

        return $record->getAttribute('converted_invoice_id') === null
            && $statusValue !== QuoteStatus::Accepted->value;
    }

    private static function canConvert(Quote $record): bool
    {
        return self::canDelete($record);
    }
}
