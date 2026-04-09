<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource;

final class RecentInvoicesWidget extends TableWidget
{
    protected static ?string $heading = 'Recent invoices';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Invoice::query()->with('customer')->latest('created_at'))
            ->columns([
                TextColumn::make('number')
                    ->label('Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.legal_name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(static fn ($state): string => $state instanceof InvoiceStatus ? $state->label() : 'Draft'),
                TextColumn::make('document_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : 'Invoice'),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->formatStateUsing(static fn ($state, Invoice $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
            ])
            ->recordUrl(static fn (Invoice $record): string => InvoiceResource::getUrl('view', ['record' => $record]))
            ->paginated([5, 10]);
    }
}
