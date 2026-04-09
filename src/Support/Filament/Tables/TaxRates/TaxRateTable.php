<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\TaxRates;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class TaxRateTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('rate')->label('Rate')->formatStateUsing(static fn ($state): string => rtrim(rtrim(number_format((float) $state, 4, '.', ''), '0'), '.').'%'),
                TextColumn::make('country')->label('Country')->badge(),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge()->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
            ])
            ->defaultSort('name');
    }
}
