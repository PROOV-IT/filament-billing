<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\CreditNotes;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class CreditNoteInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Credit note details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('invoice.number')->label('Invoice'),
                    TextEntry::make('status')->label('Status')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('number')->label('Number'),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('total_amount')->label('Total'),
                ])
                ->columns(2),
        ]);
    }
}
