<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Payments;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\PaymentMethodType;
use Proovit\Billing\Enums\PaymentStatus;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\Customer;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;
use Proovit\FilamentBilling\Support\Filament\FormPrefill;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class PaymentFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.payment_details'))
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
                            FormPrefill::companyCurrency($set, $state);
                        }),
                    Select::make('customer_id')
                        ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                        ->relationship('customer', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Customer $record): string => RecordLabel::make($record, ['legal_name', 'full_name', 'reference']))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::customerDefaults($set, $state);
                        }),
                    Select::make('invoice_id')
                        ->label(__('filament-billing::filament-billing.resources.invoice.singular'))
                        ->relationship('invoice', 'number')
                        ->getOptionLabelFromRecordUsing(static fn (Invoice $record): string => RecordLabel::make($record, ['number']))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            FormPrefill::paymentFromInvoice($set, $state);
                        }),
                    Select::make('status')
                        ->options(EnumOptions::from(PaymentStatus::class))
                        ->required()
                        ->default(PaymentStatus::Pending->value),
                    Select::make('method')
                        ->options(EnumOptions::from(PaymentMethodType::class)),
                    TextInput::make('currency')->maxLength(3)->default('EUR'),
                    TextInput::make('amount')->numeric()->required(),
                    DatePicker::make('paid_at'),
                    TextInput::make('reference')->maxLength(255),
                    Textarea::make('notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
