<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class AllocationsRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.allocation'))
                ->schema([
                    Select::make('invoice_id')
                        ->label(__('filament-billing::filament-billing.resources.invoice.singular'))
                        ->relationship('invoice', 'number')
                        ->getOptionLabelFromRecordUsing(static fn (Invoice $record): string => RecordLabel::make($record, ['number']))
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('amount')->numeric()->required(),
                ])
                ->columns(2),
        ]);
    }
}
