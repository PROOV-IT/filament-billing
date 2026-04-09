<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments\AllocationsRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments\AllocationsRelationManagerTable;

final class AllocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'allocations';

    protected static ?string $recordTitleAttribute = 'invoice_id';

    protected static ?string $title = 'Allocations';

    public function form(Schema $schema): Schema
    {
        return AllocationsRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return AllocationsRelationManagerTable::make($table);
    }
}
