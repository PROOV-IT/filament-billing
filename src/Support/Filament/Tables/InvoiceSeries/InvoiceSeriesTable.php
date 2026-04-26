<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\InvoiceSeries;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\InvoiceSeries;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;
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
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => InvoiceSeriesResource::getUrl('create')),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (InvoiceSeries $record): string => InvoiceSeriesResource::getUrl('view', ['record' => $record])),
                Action::make('edit')
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (InvoiceSeries $record): string => InvoiceSeriesResource::getUrl('edit', ['record' => $record]))
                    ->visible(fn (InvoiceSeries $record): bool => self::canEdit($record)),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (InvoiceSeries $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (InvoiceSeries $record): bool => self::canDelete($record))
            ->defaultSort('name');
    }

    private static function canEdit(InvoiceSeries $record): bool
    {
        return $record->reservations()->doesntExist()
            && $record->invoices()->doesntExist();
    }

    private static function canDelete(InvoiceSeries $record): bool
    {
        return self::canEdit($record);
    }
}
