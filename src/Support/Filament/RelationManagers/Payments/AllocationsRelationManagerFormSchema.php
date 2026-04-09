<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Payments;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class AllocationsRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Allocation')
                ->schema([
                    Select::make('invoice_id')
                        ->label('Invoice')
                        ->relationship('invoice', 'number')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('amount')->numeric()->required(),
                ])
                ->columns(2),
        ]);
    }
}
