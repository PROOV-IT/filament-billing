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
            Section::make('Product details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('sku')->label('SKU'),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('description')->label('Description')->columnSpanFull(),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('is_active')->label('Active')->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
                ])
                ->columns(2),
        ]);
    }
}
