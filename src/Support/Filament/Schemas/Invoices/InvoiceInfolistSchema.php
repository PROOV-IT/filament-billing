<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Invoices;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class InvoiceInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.document_details'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('establishment.name')->label(__('filament-billing::filament-billing.sections.establishment')),
                    TextEntry::make('customer.legal_name')->label(__('filament-billing::filament-billing.resources.customer.singular')),
                    TextEntry::make('series.name')->label(__('filament-billing::filament-billing.resources.invoice_series.singular')),
                    TextEntry::make('document_type')->label(__('filament-billing::filament-billing.columns.document_type'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('status')->label(__('filament-billing::filament-billing.columns.status'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('number')->label(__('filament-billing::filament-billing.columns.number')),
                    TextEntry::make('currency')->label(__('filament-billing::filament-billing.columns.currency')),
                    TextEntry::make('issued_at')->label(__('filament-billing::filament-billing.columns.issued_at')),
                    TextEntry::make('due_at')->label(__('filament-billing::filament-billing.columns.due_at')),
                    TextEntry::make('total_amount')->label(__('filament-billing::filament-billing.columns.total')),
                    TextEntry::make('latest_pdf_document_render_path')->label(__('filament-billing::filament-billing.columns.pdf_path'))->placeholder(__('filament-billing::filament-billing.messages.pdf_missing')),
                    TextEntry::make('notes')->label(__('filament-billing::filament-billing.columns.notes'))->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
