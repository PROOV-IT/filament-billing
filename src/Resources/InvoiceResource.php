<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource\Pages\ManageInvoices;
use Proovit\FilamentBilling\Resources\InvoiceResource\RelationManagers\LinesRelationManager;
use Proovit\FilamentBilling\Resources\InvoiceResource\RelationManagers\PaymentsRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Invoices\InvoiceFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Invoices\InvoiceInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Invoices\InvoiceTable;

final class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $slug = 'billing/invoices';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return InvoiceFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoiceTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageInvoices::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }
}
