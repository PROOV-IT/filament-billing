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
                TextColumn::make('bank_name')->label(__('filament-billing::filament-billing.columns.bank'))->searchable()->sortable(),
                TextColumn::make('account_holder')->label(__('filament-billing::filament-billing.columns.account_holder'))->searchable()->toggleable(),
                TextColumn::make('iban')->label(__('filament-billing::filament-billing.columns.iban'))->toggleable(),
                TextColumn::make('bic')->label(__('filament-billing::filament-billing.columns.bic'))->toggleable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge(),
            ])
            ->defaultSort('bank_name');
    }
}
