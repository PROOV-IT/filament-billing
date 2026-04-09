<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Products\PricesRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Products\PricesRelationManagerTable;

final class PricesRelationManager extends RelationManager
{
    protected static string $relationship = 'prices';

    protected static ?string $recordTitleAttribute = 'amount';

    protected static ?string $title = 'Prices';

    public function form(Schema $schema): Schema
    {
        return PricesRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return PricesRelationManagerTable::make($table);
    }
}
