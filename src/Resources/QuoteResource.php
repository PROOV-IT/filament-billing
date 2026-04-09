<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Quote;
use Proovit\FilamentBilling\Resources\QuoteResource\Pages\ManageQuotes;
use Proovit\FilamentBilling\Resources\QuoteResource\RelationManagers\LinesRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Quotes\QuoteFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Quotes\QuoteInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Quotes\QuoteTable;

final class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $slug = 'billing/quotes';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return QuoteFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return QuoteInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return QuoteTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuotes::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
        ];
    }
}
