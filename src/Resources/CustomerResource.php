<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Customer;
use Proovit\FilamentBilling\Resources\CustomerResource\Pages\ManageCustomers;
use Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers\AddressesRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Customers\CustomerFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Customers\CustomerInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Customers\CustomerTable;

final class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $slug = 'billing/customers';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

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
