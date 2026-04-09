<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class AddressesRelationManagerFormSchema
{
    public static function make(Schema $schema, ?string $defaultCountry = null, ?string $defaultType = 'billing'): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.address'))
                ->schema([
                    Select::make('type')
                        ->options([
                            'billing' => __('filament-billing::filament-billing.columns.type_billing'),
                            'shipping' => __('filament-billing::filament-billing.columns.type_shipping'),
                            'other' => __('filament-billing::filament-billing.columns.type_other'),
                        ])
                        ->required()
                        ->default($defaultType ?? 'billing'),
                    TextInput::make('line1')->required()->maxLength(255),
                    TextInput::make('line2')->maxLength(255),
                    TextInput::make('postal_code')->maxLength(32),
                    TextInput::make('city')->maxLength(255),
                    TextInput::make('region')->maxLength(255),
                    TextInput::make('country')->maxLength(2)->default($defaultCountry ?? 'FR'),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }
}
