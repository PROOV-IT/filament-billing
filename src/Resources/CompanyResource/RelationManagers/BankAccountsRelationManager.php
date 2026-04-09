<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies\BankAccountsRelationManagerFormSchema;
use Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies\BankAccountsRelationManagerTable;

final class BankAccountsRelationManager extends RelationManager
{
    protected static string $relationship = 'bankAccounts';

    protected static ?string $recordTitleAttribute = 'bank_name';

    protected static ?string $title = 'Bank accounts';

    public function form(Schema $schema): Schema
    {
        return BankAccountsRelationManagerFormSchema::make($schema);
    }

    public function table(Table $table): Table
    {
        return BankAccountsRelationManagerTable::make($table);
    }
}
