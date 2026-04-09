<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Invoices;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\CompanyEstablishment;
use Proovit\Billing\Models\Customer;
use Proovit\Billing\Models\InvoiceSeries;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;
use Proovit\FilamentBilling\Support\Filament\FormPrefill;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class InvoiceFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.document_details'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Company $record): string => RecordLabel::make($record, ['legal_name', 'display_name', 'name']))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::companyDefaults($set, $state);
                        }),
                    Select::make('establishment_id')
                        ->label(__('filament-billing::filament-billing.sections.establishment'))
                        ->relationship('establishment', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (CompanyEstablishment $record): string => RecordLabel::make($record, ['name', 'code']))
                        ->searchable()
                        ->preload(),
                    Select::make('customer_id')
                        ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                        ->relationship('customer', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Customer $record): string => RecordLabel::make($record, ['legal_name', 'full_name', 'reference']))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::customerDefaults($set, $state, 'currency', 'company_id', 'establishment_id');
                        }),
                    Select::make('invoice_series_id')
                        ->label(__('filament-billing::filament-billing.resources.invoice_series.singular'))
                        ->relationship('series', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (InvoiceSeries $record): string => RecordLabel::make($record, ['name', 'prefix']))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::seriesDefaults($set, $state);
                        }),
                    Select::make('document_type')
                        ->options(EnumOptions::from(InvoiceType::class))
                        ->required()
                        ->default(InvoiceType::Invoice->value),
                    Select::make('status')
                        ->options(EnumOptions::from(InvoiceStatus::class))
                        ->required()
                        ->default(InvoiceStatus::Draft->value),
                    TextInput::make('number')->maxLength(255),
                    Select::make('currency')
                        ->options([
                            'EUR' => 'EUR',
                            'USD' => 'USD',
                            'GBP' => 'GBP',
                        ])
                        ->default('EUR')
                        ->required(),
                    DatePicker::make('issued_at'),
                    DatePicker::make('due_at'),
                    DatePicker::make('finalized_at'),
                    DatePicker::make('cancelled_at'),
                    Textarea::make('notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
