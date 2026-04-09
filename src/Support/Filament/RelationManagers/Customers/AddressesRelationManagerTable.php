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
                TextColumn::make('line1')->label('Address')->searchable()->sortable(),
                TextColumn::make('postal_code')->label('Postal code')->toggleable(),
                TextColumn::make('city')->label('City')->toggleable(),
                TextColumn::make('country')->label('Country')->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge(),
            ])
            ->defaultSort('is_default', 'desc');
    }
}
