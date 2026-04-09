<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\CreditNotes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\CreditNoteStatus;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;
use Proovit\FilamentBilling\Support\Filament\FormPrefill;

final class CreditNoteFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.credit_note_details'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::companyCurrency($set, $state);
                        }),
                    Select::make('invoice_id')
                        ->label(__('filament-billing::filament-billing.resources.invoice.singular'))
                        ->relationship('invoice', 'number')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::creditNoteDefaults($set, $state);
                        }),
                    Select::make('status')
                        ->options(EnumOptions::from(CreditNoteStatus::class))
                        ->required()
                        ->default(CreditNoteStatus::Draft->value),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('currency')->maxLength(3)->default('EUR'),
                ])
                ->columns(2),
        ]);
    }
}
