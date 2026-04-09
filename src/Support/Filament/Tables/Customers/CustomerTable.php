<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Customers;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CustomerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Reference')->searchable()->toggleable(),
                TextColumn::make('legal_name')->label('Legal name')->searchable()->sortable(),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(),
                TextColumn::make('phone')->label('Phone')->toggleable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
