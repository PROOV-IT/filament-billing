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
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class PaymentsRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Payment')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'legal_name')
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
