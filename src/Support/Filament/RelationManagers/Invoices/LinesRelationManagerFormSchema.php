<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class LinesRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Line item')
                ->schema([
                    TextInput::make('sort_order')->numeric()->default(0)->required(),
                    Select::make('product_id')
                        ->label('Product')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('tax_rate_id')
                        ->label('Tax rate')
                        ->relationship('taxRate', 'name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('description')->required()->columnSpanFull(),
                    TextInput::make('quantity')->numeric()->default(1)->required(),
                    TextInput::make('unit_price')->numeric()->required(),
                    TextInput::make('discount_amount')->numeric()->default(0),
                    TextInput::make('tax_rate')->numeric()->default(0),
                    TextInput::make('subtotal_amount')->numeric()->default(0),
                    TextInput::make('tax_amount')->numeric()->default(0),
                    TextInput::make('total_amount')->numeric()->default(0),
                ])
                ->columns(2),
        ]);
    }
}
