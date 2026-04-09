<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers\AddressesRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers\AddressesRelationManagerTable;

final class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $recordTitleAttribute = 'line1';

    protected static ?string $title = 'Addresses';

    public function form(Schema $schema): Schema
    {
        return AddressesRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return AddressesRelationManagerTable::make($table);
    }
}
