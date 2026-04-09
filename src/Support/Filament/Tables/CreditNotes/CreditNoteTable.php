<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\CreditNotes;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CreditNoteTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Number')->searchable()->sortable(),
                TextColumn::make('invoice.number')->label('Invoice')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('total_amount')->label('Total'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
