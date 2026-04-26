<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Products;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\ProductPrice;

final class PricesRelationManagerTable
{
    public static function make(Table $table, bool $canManagePrices): Table
    {
        return $table
            ->columns([
                TextColumn::make('currency')->badge(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                TextColumn::make('taxRate.name')->label(__('filament-billing::filament-billing.resources.tax_rate.singular'))->toggleable(),
                TextColumn::make('starts_at')->label(__('filament-billing::filament-billing.columns.starts_at'))->date()->toggleable(),
                TextColumn::make('ends_at')->label(__('filament-billing::filament-billing.columns.ends_at'))->date()->toggleable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->visible(fn (): bool => $canManagePrices),
            ])
            ->actions([
                EditAction::make()
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->visible(fn (ProductPrice $record): bool => $canManagePrices),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (ProductPrice $record): bool => $canManagePrices),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete'))
                    ->visible(fn (): bool => $canManagePrices),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (ProductPrice $record): bool => $canManagePrices)
            ->defaultSort('starts_at', 'desc');
    }
}
