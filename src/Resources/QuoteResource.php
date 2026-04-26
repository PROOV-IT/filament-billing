<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Quote;
use Proovit\FilamentBilling\Resources\QuoteResource\Pages\CreateQuote;
use Proovit\FilamentBilling\Resources\QuoteResource\Pages\EditQuote;
use Proovit\FilamentBilling\Resources\QuoteResource\Pages\ManageQuotes;
use Proovit\FilamentBilling\Resources\QuoteResource\Pages\ViewQuote;
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

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.quote.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.quote.plural');
    }

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
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuotes::route('/'),
            'create' => CreateQuote::route('/create'),
            'view' => ViewQuote::route('/{quote}'),
            'edit' => EditQuote::route('/{quote}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
        ];
    }
}
