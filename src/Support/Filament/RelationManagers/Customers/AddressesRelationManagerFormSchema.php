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
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Address')
                ->schema([
                    Select::make('type')
                        ->options([
                            'billing' => 'Billing',
                            'shipping' => 'Shipping',
                            'other' => 'Other',
                        ])
                        ->required(),
                    TextInput::make('line1')->required()->maxLength(255),
                    TextInput::make('line2')->maxLength(255),
                    TextInput::make('postal_code')->maxLength(32),
                    TextInput::make('city')->maxLength(255),
                    TextInput::make('region')->maxLength(255),
                    TextInput::make('country')->maxLength(2),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }
}
