<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Quotes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\QuoteStatus;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class QuoteFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.quote_details'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('customer_id')
                        ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                        ->relationship('customer', 'legal_name')
                        ->searchable()
                        ->preload(),
                    Select::make('status')
                        ->options(EnumOptions::from(QuoteStatus::class))
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
                    Textarea::make('notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
