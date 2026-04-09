<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Company;
use Proovit\FilamentBilling\Resources\CompanyResource\Pages\CreateCompany;
use Proovit\FilamentBilling\Resources\CompanyResource\Pages\EditCompany;
use Proovit\FilamentBilling\Resources\CompanyResource\Pages\ManageCompanies;
use Proovit\FilamentBilling\Resources\CompanyResource\Pages\ViewCompany;
use Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers\BankAccountsRelationManager;
use Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers\EstablishmentsRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Companies\CompanyFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Companies\CompanyInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Companies\CompanyTable;

final class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $slug = 'billing/companies';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.company.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.company.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return CompanyFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompanyInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return CompanyTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'view' => ViewCompany::route('/{record}'),
            'edit' => EditCompany::route('/{record}/edit'),
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
