<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Invoices;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Invoice;

final class InvoiceTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Number')->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : 'Draft'),
                TextColumn::make('document_type')->label('Type')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('issued_at')->label('Issued')->date()->sortable()->toggleable(),
                TextColumn::make('due_at')->label('Due')->date()->toggleable(),
                TextColumn::make('total_amount')->label('Total')->formatStateUsing(static fn ($state, Invoice $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
