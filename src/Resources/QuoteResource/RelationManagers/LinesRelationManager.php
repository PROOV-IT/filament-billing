<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\QuoteResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\Billing\Models\Quote;
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

    public function form(Schema $schema): Schema
    {
        return LinesRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        $ownerRecord = $this->getOwnerRecord();

        if (! $ownerRecord instanceof Quote) {
            return $table;
        }

        return LinesRelationManagerTable::make($table, self::canManageLineItems($ownerRecord));
    }

    private static function canManageLineItems(Quote $quote): bool
    {
        $status = $quote->getAttribute('status');
        $statusValue = is_object($status) && method_exists($status, 'value') ? $status->value : (string) $status;

        return $quote->getAttribute('converted_invoice_id') === null
            && in_array($statusValue, ['draft', 'sent'], true);
    }
}
