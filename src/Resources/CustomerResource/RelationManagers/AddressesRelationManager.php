<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $recordTitleAttribute = 'line1';

    protected static ?string $title = 'Addresses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Address')
                ->schema([
                    Select::make('type')
                        ->options([
                            'billing' => 'Billing',
                            'shipping' => 'Shipping',
                            'other' => 'Other',
                        ])
                        ->required(),
                    TextInput::make('line1')->required()->maxLength(255),
                    TextInput::make('line2')->maxLength(255),
                    TextInput::make('postal_code')->maxLength(32),
                    TextInput::make('city')->maxLength(255),
                    TextInput::make('region')->maxLength(255),
                    TextInput::make('country')->maxLength(2),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->badge(),
                TextColumn::make('line1')->label('Address')->searchable()->sortable(),
                TextColumn::make('postal_code')->label('Postal code')->toggleable(),
                TextColumn::make('city')->label('City')->toggleable(),
                TextColumn::make('country')->label('Country')->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge(),
            ])
            ->defaultSort('is_default', 'desc');
    }
}
