<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Customer;
use Proovit\FilamentBilling\Resources\CustomerResource\Pages\ManageCustomers;
use Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers\AddressesRelationManager;
use Proovit\FilamentBilling\Support\Filament\AddressInfolist;
use Proovit\FilamentBilling\Support\Filament\AddressSchema;

final class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $slug = 'billing/customers';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Customer details')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('legal_name')->required()->maxLength(255),
                    TextInput::make('full_name')->maxLength(255),
                    TextInput::make('reference')->maxLength(255),
                    TextInput::make('email')->email()->maxLength(255),
                    TextInput::make('phone')->tel()->maxLength(32),
                    TextInput::make('vat_number')->maxLength(64),
                ])
                ->columns(2),
            AddressSchema::make('billing_address', 'Billing address'),
            AddressSchema::make('shipping_address', 'Shipping address'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Customer details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('legal_name')->label('Legal name'),
                    TextEntry::make('full_name')->label('Full name'),
                    TextEntry::make('reference')->label('Reference'),
                    TextEntry::make('email')->label('Email'),
                    TextEntry::make('phone')->label('Phone'),
                    TextEntry::make('vat_number')->label('VAT number'),
                ])
                ->columns(2),
            AddressInfolist::make('billing_address', 'Billing address'),
            AddressInfolist::make('shipping_address', 'Shipping address'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Reference')->searchable()->toggleable(),
                TextColumn::make('legal_name')->label('Legal name')->searchable()->sortable(),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(),
                TextColumn::make('phone')->label('Phone')->toggleable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCustomers::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            AddressesRelationManager::class,
        ];
    }
}
