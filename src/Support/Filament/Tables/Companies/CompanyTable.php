<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Companies;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Company;
use Proovit\FilamentBilling\Resources\CompanyResource;

final class CompanyTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('legal_name')->label(__('filament-billing::filament-billing.columns.legal_name'))->searchable()->sortable(),
                TextColumn::make('display_name')->label(__('filament-billing::filament-billing.columns.display_name'))->searchable()->toggleable(),
                TextColumn::make('siren')->label(__('filament-billing::filament-billing.columns.siren'))->searchable()->toggleable(),
                TextColumn::make('default_currency')->label(__('filament-billing::filament-billing.columns.currency'))->badge(),
                TextColumn::make('default_locale')->label(__('filament-billing::filament-billing.columns.locale'))->badge(),
                TextColumn::make('email')->label(__('filament-billing::filament-billing.columns.email'))->searchable()->toggleable(),
                TextColumn::make('phone')->label(__('filament-billing::filament-billing.columns.phone'))->toggleable(),
                TextColumn::make('created_at')->label(__('filament-billing::filament-billing.columns.created_at'))->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('legal_name')
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => CompanyResource::getUrl('create')),
            ])
            ->actions([
                ViewAction::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (Company $record): string => CompanyResource::getUrl('view', ['record' => $record])),
                EditAction::make('edit')
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (Company $record): string => CompanyResource::getUrl('edit', ['record' => $record])),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (Company $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (Company $record): bool => self::canDelete($record));
    }

    private static function canDelete(Company $record): bool
    {
        return $record->establishments()->doesntExist()
            && $record->bankAccounts()->doesntExist()
            && $record->customers()->doesntExist()
            && $record->invoices()->doesntExist();
    }
}
