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
                TextEntry::make("{$statePath}.line1")->label('Line 1'),
                TextEntry::make("{$statePath}.line2")->label('Line 2'),
                TextEntry::make("{$statePath}.postal_code")->label('Postal code'),
                TextEntry::make("{$statePath}.city")->label('City'),
                TextEntry::make("{$statePath}.region")->label('Region'),
                TextEntry::make("{$statePath}.country")->label('Country'),
            ])
            ->columns(2);
    }
}
