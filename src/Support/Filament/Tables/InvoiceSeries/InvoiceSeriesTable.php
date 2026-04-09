<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\InvoiceSeries;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class InvoiceSeriesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('filament-billing::filament-billing.columns.name'))->searchable()->sortable(),
                TextColumn::make('document_type')->label(__('filament-billing::filament-billing.columns.document_type'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                TextColumn::make('company.legal_name')->label(__('filament-billing::filament-billing.columns.company'))->searchable()->toggleable(),
                TextColumn::make('establishment.name')->label(__('filament-billing::filament-billing.sections.establishment'))->toggleable(),
                TextColumn::make('pattern')->label(__('filament-billing::filament-billing.columns.pattern'))->toggleable(),
                TextColumn::make('current_sequence')->label(__('filament-billing::filament-billing.columns.current_sequence'))->sortable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge()->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
            ])
            ->defaultSort('name');
    }
}
