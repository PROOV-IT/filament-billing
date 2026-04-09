<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Payments;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class PaymentTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label(__('filament-billing::filament-billing.resources.invoice.singular'))->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label(__('filament-billing::filament-billing.resources.customer.singular'))->searchable()->toggleable(),
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                TextColumn::make('method')->label(__('filament-billing::filament-billing.columns.type'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state))->toggleable(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                TextColumn::make('paid_at')->label(__('filament-billing::filament-billing.columns.paid_at'))->date()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
