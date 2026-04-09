<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Companies;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Models\CompanyEstablishment;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class BankAccountsRelationManagerFormSchema
{
    public static function make(Schema $schema, ?int $defaultEstablishmentId = null): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.bank_account'))
                ->schema([
                    Select::make('establishment_id')
                        ->label(__('filament-billing::filament-billing.sections.establishment'))
                        ->relationship('establishment', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (CompanyEstablishment $record): string => RecordLabel::make($record, ['name', 'code']))
                        ->searchable()
                        ->preload()
                        ->default($defaultEstablishmentId),
                    TextInput::make('bank_name')->required()->maxLength(255),
                    TextInput::make('account_holder')->required()->maxLength(255),
                    TextInput::make('iban')->maxLength(34),
                    TextInput::make('bic')->maxLength(16),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }
}
