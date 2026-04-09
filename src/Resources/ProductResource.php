<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Product;
use Proovit\FilamentBilling\Resources\ProductResource\Pages\CreateProduct;
use Proovit\FilamentBilling\Resources\ProductResource\Pages\EditProduct;
use Proovit\FilamentBilling\Resources\ProductResource\Pages\ManageProducts;
use Proovit\FilamentBilling\Resources\ProductResource\Pages\ViewProduct;
use Proovit\FilamentBilling\Resources\ProductResource\RelationManagers\PricesRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Products\ProductFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Products\ProductInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Products\ProductTable;

final class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'billing/products';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.product.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.product.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return ProductFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            PricesRelationManager::class,
        ];
    }
}
