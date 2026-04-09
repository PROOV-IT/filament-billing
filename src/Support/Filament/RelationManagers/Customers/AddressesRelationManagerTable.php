<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AddressesRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->badge(),
                TextColumn::make('line1')->label(__('filament-billing::filament-billing.sections.address'))->searchable()->sortable(),
                TextColumn::make('postal_code')->label(__('filament-billing::filament-billing.columns.postal_code'))->toggleable(),
                TextColumn::make('city')->label(__('filament-billing::filament-billing.columns.city'))->toggleable(),
                TextColumn::make('country')->label(__('filament-billing::filament-billing.columns.country'))->toggleable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge(),
            ])
            ->defaultSort('is_default', 'desc');
    }
}
