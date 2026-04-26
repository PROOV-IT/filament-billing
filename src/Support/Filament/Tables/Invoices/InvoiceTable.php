<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Tables\Invoices;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource;
use Proovit\FilamentBilling\Support\Filament\Actions\Invoices\InvoicePdfActions;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class InvoiceTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label(__('filament-billing::filament-billing.columns.number'))->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label(__('filament-billing::filament-billing.columns.customer'))->searchable()->sortable(),
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state, __('filament-billing::filament-billing.statuses.draft'))),
                TextColumn::make('document_type')->label(__('filament-billing::filament-billing.columns.type'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                TextColumn::make('issued_at')->label(__('filament-billing::filament-billing.columns.issued_at'))->date()->sortable()->toggleable(),
                TextColumn::make('due_at')->label(__('filament-billing::filament-billing.columns.due_at'))->date()->toggleable(),
                TextColumn::make('total_amount')->label(__('filament-billing::filament-billing.columns.total'))->formatStateUsing(static fn ($state, Invoice $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
            ])
            ->headerActions([
                Action::make('create')
                    ->label(__('filament-billing::filament-billing.actions.create'))
                    ->icon('heroicon-o-plus')
                    ->url(fn (): string => InvoiceResource::getUrl('create')),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-billing::filament-billing.actions.view'))
                    ->url(fn (Invoice $record): string => InvoiceResource::getUrl('view', ['record' => $record])),
                InvoicePdfActions::downloadTableAction(),
                Action::make('edit')
                    ->label(__('filament-billing::filament-billing.actions.edit'))
                    ->url(fn (Invoice $record): string => InvoiceResource::getUrl('edit', ['record' => $record]))
                    ->visible(fn (Invoice $record): bool => self::canEdit($record)),
                DeleteAction::make()
                    ->label(__('filament-billing::filament-billing.actions.delete'))
                    ->visible(fn (Invoice $record): bool => self::canDelete($record)),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label(__('filament-billing::filament-billing.actions.bulk_delete')),
            ])
            ->checkIfRecordIsSelectableUsing(static fn (Invoice $record): bool => self::canDelete($record))
            ->defaultSort('created_at', 'desc');
    }

    private static function canEdit(Invoice $record): bool
    {
        $status = $record->getAttribute('status');
        $statusValue = $status instanceof InvoiceStatus ? $status->value : (string) $status;

        return in_array($statusValue, [InvoiceStatus::Draft->value, InvoiceStatus::Pending->value], true);
    }

    private static function canDelete(Invoice $record): bool
    {
        $documentType = $record->getAttribute('document_type');
        $status = $record->getAttribute('status');
        $documentTypeValue = $documentType instanceof InvoiceType ? $documentType->value : (string) $documentType;
        $statusValue = $status instanceof InvoiceStatus ? $status->value : (string) $status;

        return $documentTypeValue === InvoiceType::Invoice->value
            && $statusValue === InvoiceStatus::Draft->value;
    }
}
