<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class LinesRelationManagerTable
{
    public static function make(Table $table): Table
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
            ->defaultSort('sort_order');
    }
}
