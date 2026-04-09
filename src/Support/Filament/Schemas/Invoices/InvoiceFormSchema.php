<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Invoices;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class InvoiceFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document details')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('establishment_id')
                        ->label('Establishment')
                        ->relationship('establishment', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'legal_name')
                        ->searchable()
                        ->preload(),
                    Select::make('invoice_series_id')
                        ->label('Series')
                        ->relationship('series', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('document_type')
                        ->options(EnumOptions::from(InvoiceType::class))
                        ->required(),
                    Select::make('status')
                        ->options(EnumOptions::from(InvoiceStatus::class))
                        ->required(),
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
