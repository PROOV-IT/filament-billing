<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\InvoiceSeries;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class InvoiceSeriesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('document_type')->label('Type')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->toggleable(),
                TextColumn::make('establishment.name')->label('Establishment')->toggleable(),
                TextColumn::make('pattern')->label('Pattern')->toggleable(),
                TextColumn::make('current_sequence')->label('Sequence')->sortable(),
                TextColumn::make('is_default')->label('Default')->badge()->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
            ])
            ->defaultSort('name');
    }
}
