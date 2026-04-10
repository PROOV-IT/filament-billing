<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;

final class BillingSettingsFormSchema
{
    /**
     * @return array<int, Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('filament-billing::filament-billing.settings.sections.dashboard'))
                ->description(__('filament-billing::filament-billing.settings.sections.dashboard_description'))
                ->columns(2)
                ->schema([
                    Toggle::make('dashboard.enabled')
                        ->label(__('filament-billing::filament-billing.settings.fields.dashboard_enabled')),
                    TextInput::make('dashboard.navigation_label')
                        ->label(__('filament-billing::filament-billing.settings.fields.navigation_label'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('navigation_group')
                        ->label(__('filament-billing::filament-billing.settings.fields.navigation_group'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('dashboard.recent_invoices_limit')
                        ->label(__('filament-billing::filament-billing.settings.fields.recent_invoices_limit'))
                        ->numeric()
                        ->minValue(1)
                        ->required(),
                    TextInput::make('dashboard.recent_quotes_limit')
                        ->label(__('filament-billing::filament-billing.settings.fields.recent_quotes_limit'))
                        ->numeric()
                        ->minValue(1)
                        ->required(),
                ]),
        ];
    }
}
