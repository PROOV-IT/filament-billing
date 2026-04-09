<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Products;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PricesRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('currency')->badge(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                TextColumn::make('taxRate.name')->label(__('filament-billing::filament-billing.resources.tax_rate.singular'))->toggleable(),
                TextColumn::make('starts_at')->label(__('filament-billing::filament-billing.columns.starts_at'))->date()->toggleable(),
                TextColumn::make('ends_at')->label(__('filament-billing::filament-billing.columns.ends_at'))->date()->toggleable(),
            ])
            ->defaultSort('starts_at', 'desc');
    }
}
