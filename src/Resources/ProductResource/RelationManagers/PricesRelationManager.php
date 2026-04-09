<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PricesRelationManager extends RelationManager
{
    protected static string $relationship = 'prices';

    protected static ?string $recordTitleAttribute = 'amount';

    protected static ?string $title = 'Prices';

    public function form(Schema $schema): Schema
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('currency')->badge(),
                TextColumn::make('amount')->label('Amount'),
                TextColumn::make('taxRate.name')->label('Tax rate')->toggleable(),
                TextColumn::make('starts_at')->label('Starts at')->date()->toggleable(),
                TextColumn::make('ends_at')->label('Ends at')->date()->toggleable(),
            ])
            ->defaultSort('starts_at', 'desc');
    }
}
