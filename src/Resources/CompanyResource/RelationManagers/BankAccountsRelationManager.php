<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class BankAccountsRelationManager extends RelationManager
{
    protected static string $relationship = 'bankAccounts';

    protected static ?string $recordTitleAttribute = 'bank_name';

    protected static ?string $title = 'Bank accounts';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Bank account')
                ->schema([
                    Select::make('establishment_id')
                        ->label('Establishment')
                        ->relationship('establishment', 'name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('bank_name')->required()->maxLength(255),
                    TextInput::make('account_holder')->required()->maxLength(255),
                    TextInput::make('iban')->maxLength(34),
                    TextInput::make('bic')->maxLength(16),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_name')->label('Bank')->searchable()->sortable(),
                TextColumn::make('account_holder')->label('Account holder')->searchable()->toggleable(),
                TextColumn::make('iban')->label('IBAN')->toggleable(),
                TextColumn::make('bic')->label('BIC')->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge(),
            ])
            ->defaultSort('bank_name');
    }
}
