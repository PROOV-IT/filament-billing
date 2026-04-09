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
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('code')->label('Code')->toggleable(),
                TextColumn::make('email')->label('Email')->toggleable(),
                TextColumn::make('phone')->label('Phone')->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge(),
            ])
            ->defaultSort('name');
    }
}
