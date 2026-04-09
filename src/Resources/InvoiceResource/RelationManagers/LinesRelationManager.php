<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\RelationManagers;

use BackedEnum;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices\LinesRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices\LinesRelationManagerTable;

final class LinesRelationManager extends RelationManager
{
    protected static string $relationship = 'lines';

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.sections.line_item');
    }

    public function isReadOnly(): bool
    {
        $ownerRecord = $this->getOwnerRecord();

        if (! $ownerRecord instanceof Invoice) {
            return true;
        }

        return ! self::canManageLineItems($ownerRecord);
    }

    public function form(Schema $schema): Schema
    {
        return LinesRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        $ownerRecord = $this->getOwnerRecord();

        if (! $ownerRecord instanceof Invoice) {
            return $table;
        }

        return LinesRelationManagerTable::make($table, self::canManageLineItems($ownerRecord));
    }

    private static function canManageLineItems(Invoice $invoice): bool
    {
        $documentType = $invoice->getAttribute('document_type');
        $status = $invoice->getAttribute('status');

        $documentTypeValue = $documentType instanceof BackedEnum ? $documentType->value : (string) $documentType;
        $statusValue = $status instanceof BackedEnum ? $status->value : (string) $status;

        return $documentTypeValue === 'invoice' && $statusValue === 'draft';
    }
}
