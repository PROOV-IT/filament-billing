<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\Billing\Models\Company;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies\BankAccountsRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies\BankAccountsRelationManagerTable;

final class BankAccountsRelationManager extends RelationManager
{
    protected static string $relationship = 'bankAccounts';

    protected static ?string $recordTitleAttribute = 'bank_name';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.sections.bank_account');
    }

    public function form(Schema $schema): Schema
    {
        $ownerRecord = $this->getOwnerRecord();
        if (! $ownerRecord instanceof Company) {
            return BankAccountsRelationManagerFormSchema::make($schema);
        }

        $defaultEstablishmentId = $ownerRecord->defaultEstablishment()->value('id');

        return BankAccountsRelationManagerFormSchema::make($schema, $defaultEstablishmentId ? (int) $defaultEstablishmentId : null);
    }

    public function table(Table $table): Table
    {
        return BankAccountsRelationManagerTable::make($table);
    }
}
