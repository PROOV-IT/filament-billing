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
use Proovit\Billing\Models\Company;
use Proovit\FilamentBilling\Resources\CompanyResource\Pages\ManageCompanies;
use Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers\BankAccountsRelationManager;
use Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers\EstablishmentsRelationManager;
use Proovit\FilamentBilling\Support\Filament\AddressInfolist;
use Proovit\FilamentBilling\Support\Filament\AddressSchema;

final class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $slug = 'billing/companies';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Company details')
                ->schema([
                    TextInput::make('legal_name')->required()->maxLength(255),
                    TextInput::make('display_name')->maxLength(255),
                    TextInput::make('legal_form')->maxLength(255),
                    TextInput::make('registration_country')->maxLength(2)->default('FR'),
                    TextInput::make('siren')->maxLength(9),
                    TextInput::make('siret')->maxLength(14),
                    TextInput::make('vat_number')->maxLength(64),
                    TextInput::make('intracommunity_vat_number')->maxLength(64),
                    TextInput::make('naf_ape')->maxLength(32),
                    TextInput::make('rcs_city')->maxLength(255),
                    TextInput::make('email')->email()->maxLength(255),
                    TextInput::make('phone')->tel()->maxLength(32),
                    TextInput::make('website')->url()->maxLength(255),
                    Select::make('default_currency')
                        ->options([
                            'EUR' => 'EUR',
                            'USD' => 'USD',
                            'GBP' => 'GBP',
                        ])
                        ->default('EUR')
                        ->required(),
                    TextInput::make('default_locale')->maxLength(12)->default('fr'),
                    TextInput::make('timezone')->maxLength(64)->default('Europe/Paris'),
                    TextInput::make('default_payment_terms')->numeric()->minValue(0)->default(30),
                    TextInput::make('invoice_prefix')->maxLength(32)->default('INV'),
                    TextInput::make('invoice_sequence_pattern')->maxLength(255)->default('{prefix}-{year}{month}-{sequence}'),
                ])
                ->columns(2),
            AddressSchema::make('head_office_address', 'Head office address'),
            AddressSchema::make('billing_address', 'Billing address'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Company details')
                ->schema([
                    TextEntry::make('legal_name')->label('Legal name'),
                    TextEntry::make('display_name')->label('Display name'),
                    TextEntry::make('legal_form')->label('Legal form'),
                    TextEntry::make('registration_country')->label('Country'),
                    TextEntry::make('siren')->label('SIREN'),
                    TextEntry::make('siret')->label('SIRET'),
                    TextEntry::make('vat_number')->label('VAT number'),
                    TextEntry::make('email')->label('Email'),
                    TextEntry::make('phone')->label('Phone'),
                    TextEntry::make('default_currency')->label('Currency'),
                    TextEntry::make('default_locale')->label('Locale'),
                    TextEntry::make('timezone')->label('Timezone'),
                ])
                ->columns(2),
            AddressInfolist::make('head_office_address', 'Head office address'),
            AddressInfolist::make('billing_address', 'Billing address'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('legal_name')->label('Legal name')->searchable()->sortable(),
                TextColumn::make('display_name')->label('Display name')->searchable()->toggleable(),
                TextColumn::make('siren')->label('SIREN')->searchable()->toggleable(),
                TextColumn::make('default_currency')->label('Currency')->badge(),
                TextColumn::make('default_locale')->label('Locale')->badge(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(),
                TextColumn::make('phone')->label('Phone')->toggleable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('legal_name');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCompanies::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            EstablishmentsRelationManager::class,
            BankAccountsRelationManager::class,
        ];
    }
}
