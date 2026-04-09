<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

final class AddressInfolist
{
    public static function make(string $statePath, string $label): Section
    {
        return Section::make($label)
            ->schema([
                TextEntry::make("{$statePath}.line1")->label(__('filament-billing::filament-billing.columns.line1')),
                TextEntry::make("{$statePath}.line2")->label(__('filament-billing::filament-billing.columns.line2')),
                TextEntry::make("{$statePath}.postal_code")->label(__('filament-billing::filament-billing.columns.postal_code')),
                TextEntry::make("{$statePath}.city")->label(__('filament-billing::filament-billing.columns.city')),
                TextEntry::make("{$statePath}.region")->label(__('filament-billing::filament-billing.columns.region')),
                TextEntry::make("{$statePath}.country")->label(__('filament-billing::filament-billing.columns.country')),
            ])
            ->columns(2);
    }
}
