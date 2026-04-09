<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\TaxRate;
use Proovit\FilamentBilling\Resources\TaxRateResource\Pages\ManageTaxRates;
use Proovit\FilamentBilling\Support\Filament\Schemas\TaxRates\TaxRateFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\TaxRates\TaxRateInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\TaxRates\TaxRateTable;

final class TaxRateResource extends Resource
{
    protected static ?string $model = TaxRate::class;

    protected static ?string $slug = 'billing/tax-rates';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return TaxRateFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaxRateInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return TaxRateTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTaxRates::route('/'),
        ];
    }
}
