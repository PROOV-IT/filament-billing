<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\PaymentMethodType;
use Proovit\Billing\Enums\PaymentStatus;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\Customer;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class PaymentsRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.payment'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Company $record): string => RecordLabel::make($record, ['legal_name', 'display_name', 'name']))
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('customer_id')
                        ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                        ->relationship('customer', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Customer $record): string => RecordLabel::make($record, ['legal_name', 'full_name', 'reference']))
                        ->searchable()
                        ->preload(),
                    Select::make('status')
                        ->options(EnumOptions::from(PaymentStatus::class))
                        ->required(),
                    Select::make('method')
                        ->options(EnumOptions::from(PaymentMethodType::class)),
                    TextInput::make('currency')->maxLength(3)->default('EUR'),
                    TextInput::make('amount')->numeric()->required(),
                    DatePicker::make('paid_at'),
                    TextInput::make('reference')->maxLength(255),
                ])
                ->columns(2),
        ]);
    }
}
