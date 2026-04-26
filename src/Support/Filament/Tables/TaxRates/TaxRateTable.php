<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\TaxRates;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\TaxRate;
use Proovit\FilamentBilling\Resources\TaxRateResource;

final class TaxRateTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('filament-billing::filament-billing.columns.name'))->searchable()->sortable(),
                TextColumn::make('rate')->label(__('filament-billing::filament-billing.columns.rate'))->formatStateUsing(static fn ($state): string => rtrim(rtrim(number_format((float) $state, 4, '.', ''), '0'), '.').'%'),
                TextColumn::make('country')->label(__('filament-billing::filament-billing.columns.country'))->badge(),
                TextColumn::make('company.legal_name')->label(__('filament-billing::filament-billing.columns.company'))->searchable()->toggleable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge()->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
            ])
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => TaxRateResource::getUrl('create')),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (TaxRate $record): string => TaxRateResource::getUrl('view', ['record' => $record])),
                Action::make('edit')
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (TaxRate $record): string => TaxRateResource::getUrl('edit', ['record' => $record]))
                    ->visible(fn (TaxRate $record): bool => self::canEdit($record)),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (TaxRate $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (TaxRate $record): bool => self::canDelete($record))
            ->defaultSort('name');
    }

    private static function canEdit(TaxRate $record): bool
    {
        return $record->productPrices()->doesntExist();
    }

    private static function canDelete(TaxRate $record): bool
    {
        return self::canEdit($record);
    }
}
