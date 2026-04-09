<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\InvoiceSeries;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class InvoiceSeriesInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Series details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('establishment.name')->label('Establishment'),
                    TextEntry::make('document_type')->label('Document type')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('prefix')->label('Prefix'),
                    TextEntry::make('suffix')->label('Suffix'),
                    TextEntry::make('pattern')->label('Pattern'),
                    TextEntry::make('padding')->label('Padding'),
                    TextEntry::make('reset_policy')->label('Reset policy')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('current_sequence')->label('Current sequence'),
                    TextEntry::make('is_default')->label('Default')->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
                ])
                ->columns(2),
        ]);
    }
}
