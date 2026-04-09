<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments\AllocationsRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments\AllocationsRelationManagerTable;

final class AllocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'allocations';

    protected static ?string $recordTitleAttribute = 'invoice_id';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.sections.allocation');
    }

    public function form(Schema $schema): Schema
    {
        return AllocationsRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return AllocationsRelationManagerTable::make($table);
    }
}
