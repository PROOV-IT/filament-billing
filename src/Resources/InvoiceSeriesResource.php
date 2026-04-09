<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\InvoiceSeries;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages\ManageInvoiceSeries;
use Proovit\FilamentBilling\Support\Filament\Schemas\InvoiceSeries\InvoiceSeriesFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\InvoiceSeries\InvoiceSeriesInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\InvoiceSeries\InvoiceSeriesTable;

final class InvoiceSeriesResource extends Resource
{
    protected static ?string $model = InvoiceSeries::class;

    protected static ?string $slug = 'billing/series';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-hashtag';

    protected static ?int $navigationSort = 9;

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.invoice_series.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.invoice_series.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return InvoiceSeriesFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceSeriesInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoiceSeriesTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageInvoiceSeries::route('/'),
        ];
    }
}
