<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Products;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class ProductInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.resources.product.singular'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('sku')->label(__('filament-billing::filament-billing.columns.sku')),
                    TextEntry::make('name')->label(__('filament-billing::filament-billing.columns.name')),
                    TextEntry::make('description')->label(__('filament-billing::filament-billing.columns.description'))->columnSpanFull(),
                    TextEntry::make('currency')->label(__('filament-billing::filament-billing.columns.currency')),
                    TextEntry::make('is_active')->label(__('filament-billing::filament-billing.columns.active'))->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
                ])
                ->columns(2),
        ]);
    }
}
