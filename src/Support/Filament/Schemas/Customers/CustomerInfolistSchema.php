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
            Section::make(__('filament-billing::filament-billing.sections.customer_details'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('legal_name')->label(__('filament-billing::filament-billing.columns.legal_name')),
                    TextEntry::make('full_name')->label(__('filament-billing::filament-billing.columns.name')),
                    TextEntry::make('reference')->label(__('filament-billing::filament-billing.columns.reference')),
                    TextEntry::make('email')->label(__('filament-billing::filament-billing.columns.email')),
                    TextEntry::make('phone')->label(__('filament-billing::filament-billing.columns.phone')),
                    TextEntry::make('vat_number')->label(__('filament-billing::filament-billing.columns.vat_number')),
                ])
                ->columns(2),
            AddressInfolist::make('billing_address', __('filament-billing::filament-billing.columns.billing_address')),
            AddressInfolist::make('shipping_address', __('filament-billing::filament-billing.sections.address')),
        ]);
    }
}
