<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PaymentsRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Reference')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('method')->label('Method')->badge()->toggleable(),
                TextColumn::make('amount')->label('Amount'),
                TextColumn::make('paid_at')->label('Paid at')->date()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
