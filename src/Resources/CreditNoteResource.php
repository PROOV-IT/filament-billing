<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\CreditNote;
use Proovit\FilamentBilling\Resources\CreditNoteResource\Pages\ManageCreditNotes;
use Proovit\FilamentBilling\Resources\CreditNoteResource\RelationManagers\LinesRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\CreditNotes\CreditNoteFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\CreditNotes\CreditNoteInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\CreditNotes\CreditNoteTable;

final class CreditNoteResource extends Resource
{
    protected static ?string $model = CreditNote::class;

    protected static ?string $slug = 'billing/credit-notes';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.credit_note.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.credit_note.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return CreditNoteFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CreditNoteInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return CreditNoteTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCreditNotes::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
        ];
    }
}
