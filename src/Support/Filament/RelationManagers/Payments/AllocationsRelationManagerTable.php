<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AllocationsRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label('Invoice')->searchable()->sortable(),
                TextColumn::make('amount')->label('Amount'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
