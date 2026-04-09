<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\CreditNotes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\CreditNoteStatus;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

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
                        ->required(),
                    Select::make('invoice_id')
                        ->label(__('filament-billing::filament-billing.resources.invoice.singular'))
                        ->relationship('invoice', 'number')
                        ->searchable()
                        ->preload(),
                    Select::make('status')
                        ->options(EnumOptions::from(CreditNoteStatus::class))
                        ->required(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('currency')->maxLength(3)->default('EUR'),
                ])
                ->columns(2),
        ]);
    }
}
