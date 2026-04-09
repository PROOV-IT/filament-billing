<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\InvoiceSeries;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Enums\SequenceResetPolicy;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class InvoiceSeriesFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Series details')
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
                    Select::make('document_type')
                        ->options(EnumOptions::from(InvoiceType::class))
                        ->required(),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('prefix')->maxLength(32),
                    TextInput::make('suffix')->maxLength(32),
                    TextInput::make('pattern')->maxLength(255)->default('{prefix}-{year}{month}-{sequence}'),
                    TextInput::make('padding')->numeric()->default(6)->required(),
                    Select::make('reset_policy')
                        ->options(EnumOptions::from(SequenceResetPolicy::class))
                        ->required(),
                    TextInput::make('current_sequence')->numeric()->default(0)->required(),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }
}
