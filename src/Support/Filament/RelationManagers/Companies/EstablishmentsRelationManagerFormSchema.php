<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class EstablishmentsRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Establishment')
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('code')->maxLength(255),
                    TextInput::make('email')->email()->maxLength(255),
                    TextInput::make('phone')->tel()->maxLength(32),
                    Toggle::make('is_default')->default(false),
                    TextInput::make('address.line1')->label('Address line 1')->maxLength(255),
                    TextInput::make('address.line2')->label('Address line 2')->maxLength(255),
                    TextInput::make('address.postal_code')->label('Postal code')->maxLength(32),
                    TextInput::make('address.city')->label('City')->maxLength(255),
                    TextInput::make('address.region')->label('Region')->maxLength(255),
                    TextInput::make('address.country')->label('Country')->maxLength(2),
                ])
                ->columns(2),
        ]);
    }
}
