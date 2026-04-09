<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Company;
use Proovit\FilamentBilling\Resources\CompanyResource\Pages\ManageCompanies;
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
