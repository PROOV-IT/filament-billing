<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CreditNoteResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices\LinesRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices\LinesRelationManagerTable;

final class LinesRelationManager extends RelationManager
{
    protected static string $relationship = 'lines';

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $title = 'Line items';

    public function form(Schema $schema): Schema
    {
        return LinesRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return LinesRelationManagerTable::make($table);
    }
}
