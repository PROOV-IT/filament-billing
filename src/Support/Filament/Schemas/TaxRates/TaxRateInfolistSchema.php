<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\TaxRates;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class TaxRateInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tax rate')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('rate')->label('Rate'),
                    TextEntry::make('country')->label('Country'),
                    TextEntry::make('is_default')->label('Default')->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
                ])
                ->columns(2),
        ]);
    }
}
