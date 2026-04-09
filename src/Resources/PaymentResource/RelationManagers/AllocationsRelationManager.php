<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AllocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'allocations';

    protected static ?string $recordTitleAttribute = 'invoice_id';

    protected static ?string $title = 'Allocations';

    public function form(Schema $schema): Schema
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label('Invoice')->searchable()->sortable(),
                TextColumn::make('amount')->label('Amount'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
