<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Customer;
use Proovit\FilamentBilling\Resources\CustomerResource\Pages\CreateCustomer;
use Proovit\FilamentBilling\Resources\CustomerResource\Pages\EditCustomer;
use Proovit\FilamentBilling\Resources\CustomerResource\Pages\ManageCustomers;
use Proovit\FilamentBilling\Resources\CustomerResource\Pages\ViewCustomer;
use Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers\AddressesRelationManager;
use Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers\InvoicesRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Customers\CustomerFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Customers\CustomerInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Customers\CustomerTable;

final class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $slug = 'billing/customers';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.customer.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.customer.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustomerInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomerTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'view' => ViewCustomer::route('/{record}'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            AddressesRelationManager::class,
            InvoicesRelationManager::class,
        ];
    }
}
