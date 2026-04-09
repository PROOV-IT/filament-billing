<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Customers;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\AddressInfolist;

final class CustomerInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Customer details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('legal_name')->label('Legal name'),
                    TextEntry::make('full_name')->label('Full name'),
                    TextEntry::make('reference')->label('Reference'),
                    TextEntry::make('email')->label('Email'),
                    TextEntry::make('phone')->label('Phone'),
                    TextEntry::make('vat_number')->label('VAT number'),
                ])
                ->columns(2),
            AddressInfolist::make('billing_address', 'Billing address'),
            AddressInfolist::make('shipping_address', 'Shipping address'),
        ]);
    }
}
