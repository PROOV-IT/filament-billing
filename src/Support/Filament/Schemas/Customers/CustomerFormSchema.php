<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Customers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\AddressSchema;

final class CustomerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.customer_details'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('legal_name')->required()->maxLength(255),
                    TextInput::make('full_name')->maxLength(255),
                    TextInput::make('reference')->maxLength(255),
                    TextInput::make('email')->email()->maxLength(255),
                    TextInput::make('phone')->tel()->maxLength(32),
                    TextInput::make('vat_number')->maxLength(64),
                ])
                ->columns(2),
            AddressSchema::make('billing_address', __('filament-billing::filament-billing.columns.billing_address')),
            AddressSchema::make('shipping_address', __('filament-billing::filament-billing.sections.address')),
        ]);
    }
}
