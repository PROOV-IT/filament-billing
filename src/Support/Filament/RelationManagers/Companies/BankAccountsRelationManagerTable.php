<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class BankAccountsRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_name')->label('Bank')->searchable()->sortable(),
                TextColumn::make('account_holder')->label('Account holder')->searchable()->toggleable(),
                TextColumn::make('iban')->label('IBAN')->toggleable(),
                TextColumn::make('bic')->label('BIC')->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge(),
            ])
            ->defaultSort('bank_name');
    }
}
