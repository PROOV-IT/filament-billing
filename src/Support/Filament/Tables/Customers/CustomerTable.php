<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Customers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Customer;
use Proovit\FilamentBilling\Resources\CustomerResource;

final class CustomerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label(__('filament-billing::filament-billing.columns.reference'))->searchable()->toggleable(),
                TextColumn::make('legal_name')->label(__('filament-billing::filament-billing.columns.legal_name'))->searchable()->sortable(),
                TextColumn::make('company.legal_name')->label(__('filament-billing::filament-billing.columns.company'))->searchable()->sortable(),
                TextColumn::make('email')->label(__('filament-billing::filament-billing.columns.email'))->searchable()->toggleable(),
                TextColumn::make('phone')->label(__('filament-billing::filament-billing.columns.phone'))->toggleable(),
                TextColumn::make('created_at')->label(__('filament-billing::filament-billing.columns.created_at'))->dateTime()->sortable()->toggleable(),
            ])
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => CustomerResource::getUrl('create')),
            ])
            ->actions([
                ViewAction::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ,
                EditAction::make('edit')
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    
                    ->visible(fn (Customer $record): bool => self::canEdit($record)),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (Customer $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (Customer $record): bool => self::canDelete($record))
            ->defaultSort('created_at', 'desc');
    }

    private static function canEdit(Customer $record): bool
    {
        return true;
    }

    private static function canDelete(Customer $record): bool
    {
        return $record->invoices()->doesntExist();
    }
}
