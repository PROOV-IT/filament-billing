<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Companies;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\AddressInfolist;

final class CompanyInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Company details')
                ->schema([
                    TextEntry::make('legal_name')->label('Legal name'),
                    TextEntry::make('display_name')->label('Display name'),
                    TextEntry::make('legal_form')->label('Legal form'),
                    TextEntry::make('registration_country')->label('Country'),
                    TextEntry::make('siren')->label('SIREN'),
                    TextEntry::make('siret')->label('SIRET'),
                    TextEntry::make('vat_number')->label('VAT number'),
                    TextEntry::make('email')->label('Email'),
                    TextEntry::make('phone')->label('Phone'),
                    TextEntry::make('default_currency')->label('Currency'),
                    TextEntry::make('default_locale')->label('Locale'),
                    TextEntry::make('timezone')->label('Timezone'),
                ])
                ->columns(2),
            AddressInfolist::make('head_office_address', 'Head office address'),
            AddressInfolist::make('billing_address', 'Billing address'),
        ]);
    }
}
