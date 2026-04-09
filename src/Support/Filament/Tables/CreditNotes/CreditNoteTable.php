<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\CreditNotes;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class CreditNoteTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label(__('filament-billing::filament-billing.columns.number'))->searchable()->sortable(),
                TextColumn::make('invoice.number')->label(__('filament-billing::filament-billing.resources.invoice.singular'))->searchable()->toggleable(),
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state, __('filament-billing::filament-billing.statuses.draft'))),
                TextColumn::make('total_amount')->label(__('filament-billing::filament-billing.columns.total')),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
