<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Products;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
            ->defaultSort('name');
    }
}
