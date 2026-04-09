<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

final class AddressSchema
{
    public static function make(string $statePath, string $label): Section
    {
        return Section::make($label)
            ->schema([
                TextInput::make("{$statePath}.line1")
                    ->label('Line 1')
                    ->maxLength(255),
                TextInput::make("{$statePath}.line2")
                    ->label('Line 2')
                    ->maxLength(255),
                TextInput::make("{$statePath}.postal_code")
                    ->label('Postal code')
                    ->maxLength(32),
                TextInput::make("{$statePath}.city")
                    ->label('City')
                    ->maxLength(255),
                TextInput::make("{$statePath}.region")
                    ->label('Region')
                    ->maxLength(255),
                TextInput::make("{$statePath}.country")
                    ->label('Country')
                    ->maxLength(2)
                    ->placeholder('FR'),
            ])
            ->columns(2);
    }
}
