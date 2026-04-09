<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Invoice;
use Proovit\Billing\Models\InvoiceLine;

final class LinesRelationManagerTable
{
    public static function make(Table $table, Invoice $ownerRecord): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label(__('filament-billing::filament-billing.columns.order'))->sortable(),
                TextColumn::make('product.name')->label(__('filament-billing::filament-billing.columns.product'))->toggleable(),
                TextColumn::make('description')->label(__('filament-billing::filament-billing.columns.description'))->searchable()->sortable(),
                TextColumn::make('quantity')->label(__('filament-billing::filament-billing.columns.quantity')),
                TextColumn::make('unit_price')->label(__('filament-billing::filament-billing.columns.unit_price')),
                TextColumn::make('total_amount')->label(__('filament-billing::filament-billing.columns.total')),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->visible(fn (): bool => $ownerRecord->isEditableDraft()),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->visible(fn (InvoiceLine $record): bool => $ownerRecord->isEditableDraft()),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (InvoiceLine $record): bool => $ownerRecord->isEditableDraft()),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete'))
                    ->visible(fn (): bool => $ownerRecord->isEditableDraft()),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (InvoiceLine $record): bool => $ownerRecord->isEditableDraft())
            ->defaultSort('sort_order');
    }
}
