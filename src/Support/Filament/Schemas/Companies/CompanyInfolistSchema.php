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
            Section::make(__('filament-billing::filament-billing.sections.company_details'))
                ->schema([
                    TextEntry::make('legal_name')->label(__('filament-billing::filament-billing.columns.legal_name')),
                    TextEntry::make('display_name')->label(__('filament-billing::filament-billing.columns.display_name')),
                    TextEntry::make('legal_form')->label(__('filament-billing::filament-billing.columns.legal_form')),
                    TextEntry::make('registration_country')->label(__('filament-billing::filament-billing.columns.country')),
                    TextEntry::make('siren')->label(__('filament-billing::filament-billing.columns.siren')),
                    TextEntry::make('siret')->label(__('filament-billing::filament-billing.columns.siret')),
                    TextEntry::make('vat_number')->label(__('filament-billing::filament-billing.columns.vat_number')),
                    TextEntry::make('email')->label(__('filament-billing::filament-billing.columns.email')),
                    TextEntry::make('phone')->label(__('filament-billing::filament-billing.columns.phone')),
                    TextEntry::make('default_currency')->label(__('filament-billing::filament-billing.columns.currency')),
                    TextEntry::make('default_locale')->label(__('filament-billing::filament-billing.columns.locale')),
                    TextEntry::make('timezone')->label(__('filament-billing::filament-billing.columns.timezone')),
                ])
                ->columns(2),
            AddressInfolist::make('head_office_address', __('filament-billing::filament-billing.columns.head_office_address')),
            AddressInfolist::make('billing_address', __('filament-billing::filament-billing.columns.billing_address')),
        ]);
    }
}
