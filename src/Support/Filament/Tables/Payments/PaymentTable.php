<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Payments;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PaymentTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label('Invoice')->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label('Customer')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('method')->label('Method')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state)->toggleable(),
                TextColumn::make('amount')->label('Amount'),
                TextColumn::make('paid_at')->label('Paid at')->date()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
