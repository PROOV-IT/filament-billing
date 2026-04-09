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
            Section::make(__('filament-billing::filament-billing.resources.tax_rate.singular'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('name')->label(__('filament-billing::filament-billing.columns.name')),
                    TextEntry::make('rate')->label(__('filament-billing::filament-billing.columns.rate')),
                    TextEntry::make('country')->label(__('filament-billing::filament-billing.columns.country')),
                    TextEntry::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
                ])
                ->columns(2),
        ]);
    }
}
