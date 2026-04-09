<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Invoices;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class InvoiceInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('establishment.name')->label('Establishment'),
                    TextEntry::make('customer.legal_name')->label('Customer'),
                    TextEntry::make('series.name')->label('Series'),
                    TextEntry::make('document_type')->label('Type')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('status')->label('Status')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('number')->label('Number'),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('issued_at')->label('Issued at'),
                    TextEntry::make('due_at')->label('Due at'),
                    TextEntry::make('total_amount')->label('Total'),
                    TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
