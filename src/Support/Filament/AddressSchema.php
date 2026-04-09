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
                    ->label(__('filament-billing::filament-billing.columns.line1'))
                    ->maxLength(255),
                TextInput::make("{$statePath}.line2")
                    ->label(__('filament-billing::filament-billing.columns.line2'))
                    ->maxLength(255),
                TextInput::make("{$statePath}.postal_code")
                    ->label(__('filament-billing::filament-billing.columns.postal_code'))
                    ->maxLength(32),
                TextInput::make("{$statePath}.city")
                    ->label(__('filament-billing::filament-billing.columns.city'))
                    ->maxLength(255),
                TextInput::make("{$statePath}.region")
                    ->label(__('filament-billing::filament-billing.columns.region'))
                    ->maxLength(255),
                TextInput::make("{$statePath}.country")
                    ->label(__('filament-billing::filament-billing.columns.country'))
                    ->maxLength(2)
                    ->placeholder('FR'),
            ])
            ->columns(2);
    }
}
