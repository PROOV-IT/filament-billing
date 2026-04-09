<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\Billing\Models\Customer;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers\AddressesRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers\AddressesRelationManagerTable;

final class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $recordTitleAttribute = 'line1';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.resources.customer.plural');
    }

    public function form(Schema $schema): Schema
    {
        $ownerRecord = $this->getOwnerRecord();
        $defaultCountry = null;

        if ($ownerRecord instanceof Customer && $ownerRecord->company) {
            $defaultCountry = (string) ($ownerRecord->company->getAttribute('registration_country') ?? 'FR');
        }

        return AddressesRelationManagerFormSchema::make($schema, $defaultCountry, 'billing');
    }

    public function table(Table $table): Table
    {
        return AddressesRelationManagerTable::make($table);
    }
}
