<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Products;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class PricesRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Price')
                ->schema([
                    Select::make('tax_rate_id')
                        ->label('Tax rate')
                        ->relationship('taxRate', 'name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('currency')->maxLength(3)->default('EUR')->required(),
                    TextInput::make('amount')->numeric()->required(),
                    DatePicker::make('starts_at'),
                    DatePicker::make('ends_at'),
                ])
                ->columns(2),
        ]);
    }
}
