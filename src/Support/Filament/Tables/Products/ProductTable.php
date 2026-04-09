<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Products;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Product;
use Proovit\FilamentBilling\Resources\ProductResource;

final class ProductTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('filament-billing::filament-billing.columns.name'))->searchable()->sortable(),
                TextColumn::make('sku')->label(__('filament-billing::filament-billing.columns.sku'))->searchable()->toggleable(),
                TextColumn::make('company.legal_name')->label(__('filament-billing::filament-billing.columns.company'))->searchable()->toggleable(),
                TextColumn::make('currency')->label(__('filament-billing::filament-billing.columns.currency'))->badge(),
                IconColumn::make('is_active')->label(__('filament-billing::filament-billing.columns.active'))->boolean(),
                TextColumn::make('created_at')->label(__('filament-billing::filament-billing.columns.created_at'))->dateTime()->sortable()->toggleable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => ProductResource::getUrl('create')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (Product $record): string => ProductResource::getUrl('view', ['record' => $record->getRouteKey()])),
                EditAction::make()
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (Product $record): string => ProductResource::getUrl('edit', ['record' => $record->getRouteKey()])),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (Product $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (Product $record): bool => self::canDelete($record))
            ->defaultSort('name');
    }

    private static function canDelete(Product $record): bool
    {
        return $record->prices()->doesntExist();
    }
}
