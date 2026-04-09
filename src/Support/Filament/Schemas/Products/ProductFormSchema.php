<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Products;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class ProductFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Product details')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('sku')->maxLength(255),
                    TextInput::make('name')->required()->maxLength(255),
                    Textarea::make('description')->rows(4)->columnSpanFull(),
                    Select::make('currency')
                        ->options([
                            'EUR' => 'EUR',
                            'USD' => 'USD',
                            'GBP' => 'GBP',
                        ])
                        ->default('EUR')
                        ->required(),
                    Toggle::make('is_active')->default(true),
                ])
                ->columns(2),
        ]);
    }
}
