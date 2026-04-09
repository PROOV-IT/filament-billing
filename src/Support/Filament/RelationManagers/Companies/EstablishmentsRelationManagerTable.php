<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class EstablishmentsRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('filament-billing::filament-billing.columns.name'))->searchable()->sortable(),
                TextColumn::make('code')->label(__('filament-billing::filament-billing.columns.code'))->toggleable(),
                TextColumn::make('email')->label(__('filament-billing::filament-billing.columns.email'))->toggleable(),
                TextColumn::make('phone')->label(__('filament-billing::filament-billing.columns.phone'))->toggleable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge(),
            ])
            ->defaultSort('name');
    }
}
