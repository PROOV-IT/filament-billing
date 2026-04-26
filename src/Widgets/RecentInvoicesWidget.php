<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Widgets;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class RecentInvoicesWidget extends TableWidget
{
    protected static ?string $heading = null;

    public function getHeading(): string
    {
        return __('filament-billing::filament-billing.resources.invoice.plural');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Invoice::query()->with('customer')->latest('created_at'))
            ->columns([
                TextColumn::make('number')
                    ->label(__('filament-billing::filament-billing.columns.number'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.legal_name')
                    ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(static fn ($state): string => EnumLabel::make($state, __('filament-billing::filament-billing.statuses.draft'))),
                TextColumn::make('document_type')
                    ->label(__('filament-billing::filament-billing.columns.type'))
                    ->badge()
                    ->formatStateUsing(static fn ($state): string => EnumLabel::make($state, __('filament-billing::filament-billing.resources.invoice.singular'))),
                TextColumn::make('total_amount')
                    ->label(__('filament-billing::filament-billing.columns.total'))
                    ->formatStateUsing(static fn ($state, Invoice $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (Invoice $record): string => InvoiceResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated([5, 10]);
    }
}
