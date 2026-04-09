<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Quotes;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class QuoteInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.quote_details'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('customer.legal_name')->label(__('filament-billing::filament-billing.resources.customer.singular')),
                    TextEntry::make('status')->label(__('filament-billing::filament-billing.columns.status'))->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('number')->label(__('filament-billing::filament-billing.columns.number')),
                    TextEntry::make('currency')->label(__('filament-billing::filament-billing.columns.currency')),
                    TextEntry::make('total_amount')->label(__('filament-billing::filament-billing.columns.total')),
                    TextEntry::make('notes')->label(__('filament-billing::filament-billing.columns.notes'))->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
