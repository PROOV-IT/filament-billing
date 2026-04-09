<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Companies;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CompanyTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('legal_name')->label('Legal name')->searchable()->sortable(),
                TextColumn::make('display_name')->label('Display name')->searchable()->toggleable(),
                TextColumn::make('siren')->label('SIREN')->searchable()->toggleable(),
                TextColumn::make('default_currency')->label('Currency')->badge(),
                TextColumn::make('default_locale')->label('Locale')->badge(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(),
                TextColumn::make('phone')->label('Phone')->toggleable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('legal_name');
    }
}
