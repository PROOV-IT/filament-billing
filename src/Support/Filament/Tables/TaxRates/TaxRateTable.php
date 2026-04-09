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
                TextColumn::make('name')->label(__('filament-billing::filament-billing.columns.name'))->searchable()->sortable(),
                TextColumn::make('rate')->label(__('filament-billing::filament-billing.columns.rate'))->formatStateUsing(static fn ($state): string => rtrim(rtrim(number_format((float) $state, 4, '.', ''), '0'), '.').'%'),
                TextColumn::make('country')->label(__('filament-billing::filament-billing.columns.country'))->badge(),
                TextColumn::make('company.legal_name')->label(__('filament-billing::filament-billing.columns.company'))->searchable()->toggleable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge()->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
            ])
            ->defaultSort('name');
    }
}
