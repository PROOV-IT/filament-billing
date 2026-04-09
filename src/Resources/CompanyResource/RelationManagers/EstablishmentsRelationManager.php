<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies\EstablishmentsRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies\EstablishmentsRelationManagerTable;

final class EstablishmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'establishments';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.sections.establishment');
    }

    public function form(Schema $schema): Schema
    {
        return EstablishmentsRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return EstablishmentsRelationManagerTable::make($table);
    }
}
