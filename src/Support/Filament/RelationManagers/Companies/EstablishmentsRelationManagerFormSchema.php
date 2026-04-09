<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class EstablishmentsRelationManagerFormSchema
{
    public static function make(Schema $schema, ?string $defaultCountry = null): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.establishment'))
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('code')->maxLength(255),
                    TextInput::make('email')->email()->maxLength(255),
                    TextInput::make('phone')->tel()->maxLength(32),
                    Toggle::make('is_default')->default(false),
                    TextInput::make('address.line1')->label(__('filament-billing::filament-billing.columns.line1'))->maxLength(255),
                    TextInput::make('address.line2')->label(__('filament-billing::filament-billing.columns.line2'))->maxLength(255),
                    TextInput::make('address.postal_code')->label(__('filament-billing::filament-billing.columns.postal_code'))->maxLength(32),
                    TextInput::make('address.city')->label(__('filament-billing::filament-billing.columns.city'))->maxLength(255),
                    TextInput::make('address.region')->label(__('filament-billing::filament-billing.columns.region'))->maxLength(255),
                    TextInput::make('address.country')
                        ->label(__('filament-billing::filament-billing.columns.country'))
                        ->maxLength(2)
                        ->default($defaultCountry ?? 'FR'),
                ])
                ->columns(2),
        ]);
    }
}
