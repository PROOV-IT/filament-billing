<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Payments;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\PaymentStatus;
use Proovit\Billing\Models\Payment;
use Proovit\FilamentBilling\Resources\PaymentResource;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class PaymentTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label(__('filament-billing::filament-billing.columns.invoice'))->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label(__('filament-billing::filament-billing.resources.customer.singular'))->searchable()->toggleable(),
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                TextColumn::make('method')->label(__('filament-billing::filament-billing.columns.type'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state))->toggleable(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                TextColumn::make('paid_at')->label(__('filament-billing::filament-billing.columns.paid_at'))->date()->toggleable(),
            ])
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => PaymentResource::getUrl('create')),
            ])
            ->actions([
                Action::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (Payment $record): string => PaymentResource::getUrl('view', ['record' => $record])),
                Action::make('edit')
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (Payment $record): string => PaymentResource::getUrl('edit', ['record' => $record]))
                    ->visible(fn (Payment $record): bool => self::canEdit($record)),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (Payment $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (Payment $record): bool => self::canDelete($record))
            ->defaultSort('created_at', 'desc');
    }

    private static function canEdit(Payment $record): bool
    {
        $status = $record->getAttribute('status');
        $statusValue = $status instanceof PaymentStatus ? $status->value : (string) $status;

        return $record->allocations()->doesntExist()
            && in_array($statusValue, [PaymentStatus::Pending->value, PaymentStatus::Failed->value, PaymentStatus::Refunded->value], true);
    }

    private static function canDelete(Payment $record): bool
    {
        return self::canEdit($record);
    }
}
