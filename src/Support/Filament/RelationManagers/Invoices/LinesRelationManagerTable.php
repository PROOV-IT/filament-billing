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
                TextColumn::make('sort_order')->label('Order')->sortable(),
                TextColumn::make('product.name')->label('Product')->toggleable(),
                TextColumn::make('description')->label('Description')->searchable()->sortable(),
                TextColumn::make('quantity')->label('Qty'),
                TextColumn::make('unit_price')->label('Unit price'),
                TextColumn::make('total_amount')->label('Total'),
            ])
            ->defaultSort('sort_order');
    }
}
