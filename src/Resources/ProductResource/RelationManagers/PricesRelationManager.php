<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\Billing\Models\Product;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Products\PricesRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Products\PricesRelationManagerTable;

final class PricesRelationManager extends RelationManager
{
    protected static string $relationship = 'prices';

    protected static ?string $recordTitleAttribute = 'amount';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.sections.price');
    }

    public function form(Schema $schema): Schema
    {
        $ownerRecord = $this->getOwnerRecord();
        $defaultCurrency = null;

        if ($ownerRecord instanceof Product && $ownerRecord->company) {
            $defaultCurrency = (string) ($ownerRecord->company->getAttribute('default_currency') ?? 'EUR');
        } elseif ($ownerRecord instanceof Product) {
            $defaultCurrency = (string) ($ownerRecord->getAttribute('default_currency') ?? 'EUR');
        }

        return PricesRelationManagerFormSchema::make($schema, $defaultCurrency);
    }

    public function table(Table $table): Table
    {
        $ownerRecord = $this->getOwnerRecord();

        if (! $ownerRecord instanceof Product) {
            return $table;
        }

        return PricesRelationManagerTable::make($table, $ownerRecord->canManagePrices());
    }

    public function isReadOnly(): bool
    {
        $ownerRecord = $this->getOwnerRecord();

        if (! $ownerRecord instanceof Product) {
            return true;
        }

        return ! $ownerRecord->canManagePrices();
    }
}
