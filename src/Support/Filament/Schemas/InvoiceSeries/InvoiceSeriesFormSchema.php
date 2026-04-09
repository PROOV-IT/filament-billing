<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\InvoiceSeries;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Enums\SequenceResetPolicy;
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\CompanyEstablishment;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;
use Proovit\FilamentBilling\Support\Filament\FormPrefill;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class InvoiceSeriesFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.series_details'))
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
                            FormPrefill::companySeriesDefaults($set, $state);
                        }),
                    Select::make('establishment_id')
                        ->label(__('filament-billing::filament-billing.sections.establishment'))
                        ->relationship('establishment', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (CompanyEstablishment $record): string => RecordLabel::make($record, ['name', 'code']))
                        ->searchable()
                        ->preload(),
                    Select::make('document_type')
                        ->options(EnumOptions::from(InvoiceType::class))
                        ->required()
                        ->default(InvoiceType::Invoice->value),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('prefix')->maxLength(32),
                    TextInput::make('suffix')->maxLength(32),
                    TextInput::make('pattern')->maxLength(255)->default('{prefix}-{year}{month}-{sequence}'),
                    TextInput::make('padding')->numeric()->default(6)->required(),
                    Select::make('reset_policy')
                        ->options(EnumOptions::from(SequenceResetPolicy::class))
                        ->required()
                        ->default(SequenceResetPolicy::Annual->value),
                    TextInput::make('current_sequence')->numeric()->default(0)->required(),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }
}
