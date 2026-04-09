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
                TextColumn::make('invoice.number')->label(__('filament-billing::filament-billing.resources.invoice.singular'))->searchable()->sortable(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
