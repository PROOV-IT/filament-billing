<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Products;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Models\TaxRate;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class PricesRelationManagerFormSchema
{
    public static function make(Schema $schema, ?string $defaultCurrency = null): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.price'))
                ->schema([
                    Select::make('tax_rate_id')
                        ->label(__('filament-billing::filament-billing.resources.tax_rate.singular'))
                        ->relationship('taxRate', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (TaxRate $record): string => RecordLabel::make($record, ['name', 'rate']))
                        ->searchable()
                        ->preload(),
                    TextInput::make('currency')->maxLength(3)->default($defaultCurrency ?? 'EUR')->required(),
                    TextInput::make('amount')->numeric()->required(),
                    DatePicker::make('starts_at'),
                    DatePicker::make('ends_at'),
                ])
                ->columns(2),
        ]);
    }
}
