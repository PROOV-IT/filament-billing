<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\TaxRates;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Models\Company;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class TaxRateFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.resources.tax_rate.singular'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Company $record): string => RecordLabel::make($record, ['legal_name', 'display_name', 'name']))
                        ->searchable()
                        ->preload(),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('rate')->numeric()->step(0.0001)->required(),
                    TextInput::make('country')->maxLength(2)->default('FR'),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }
}
