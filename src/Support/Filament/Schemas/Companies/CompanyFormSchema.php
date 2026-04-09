<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Companies;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\AddressSchema;

final class CompanyFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Company details')
                ->schema([
                    TextInput::make('legal_name')->required()->maxLength(255),
                    TextInput::make('display_name')->maxLength(255),
                    TextInput::make('legal_form')->maxLength(255),
                    TextInput::make('registration_country')->maxLength(2)->default('FR'),
                    TextInput::make('siren')->maxLength(9),
                    TextInput::make('siret')->maxLength(14),
                    TextInput::make('vat_number')->maxLength(64),
                    TextInput::make('intracommunity_vat_number')->maxLength(64),
                    TextInput::make('naf_ape')->maxLength(32),
                    TextInput::make('rcs_city')->maxLength(255),
                    TextInput::make('email')->email()->maxLength(255),
                    TextInput::make('phone')->tel()->maxLength(32),
                    TextInput::make('website')->url()->maxLength(255),
                    Select::make('default_currency')
                        ->options([
                            'EUR' => 'EUR',
                            'USD' => 'USD',
                            'GBP' => 'GBP',
                        ])
                        ->default('EUR')
                        ->required(),
                    TextInput::make('default_locale')->maxLength(12)->default('fr'),
                    TextInput::make('timezone')->maxLength(64)->default('Europe/Paris'),
                    TextInput::make('default_payment_terms')->numeric()->minValue(0)->default(30),
                    TextInput::make('invoice_prefix')->maxLength(32)->default('INV'),
                    TextInput::make('invoice_sequence_pattern')->maxLength(255)->default('{prefix}-{year}{month}-{sequence}'),
                ])
                ->columns(2),
            AddressSchema::make('head_office_address', 'Head office address'),
            AddressSchema::make('billing_address', 'Billing address'),
        ]);
    }
}
