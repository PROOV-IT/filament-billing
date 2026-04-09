<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\QuoteResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class LinesRelationManager extends RelationManager
{
    protected static string $relationship = 'lines';

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $title = 'Line items';

    public function form(Schema $schema): Schema
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('Order')->sortable(),
                TextColumn::make('product.name')->label('Product')->toggleable(),
                TextColumn::make('description')->label('Description')->searchable()->sortable(),
                TextColumn::make('quantity')->label('Qty'),
                TextColumn::make('unit_price')->label('Unit price'),
                TextColumn::make('total_amount')->label('Total'),
            ])
            ->defaultSort('sort_order');
    }
}
