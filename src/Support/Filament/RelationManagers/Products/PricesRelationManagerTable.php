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
                TextColumn::make('amount')->label('Amount'),
                TextColumn::make('taxRate.name')->label('Tax rate')->toggleable(),
                TextColumn::make('starts_at')->label('Starts at')->date()->toggleable(),
                TextColumn::make('ends_at')->label('Ends at')->date()->toggleable(),
            ])
            ->defaultSort('starts_at', 'desc');
    }
}
