<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\CreditNotes;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class CreditNoteInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.credit_note_details'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('invoice.number')->label(__('filament-billing::filament-billing.resources.invoice.singular')),
                    TextEntry::make('status')->label(__('filament-billing::filament-billing.columns.status'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('number')->label(__('filament-billing::filament-billing.columns.number')),
                    TextEntry::make('currency')->label(__('filament-billing::filament-billing.columns.currency')),
                    TextEntry::make('total_amount')->label(__('filament-billing::filament-billing.columns.total')),
                ])
                ->columns(2),
        ]);
    }
}
