<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\CreditNoteStatus;
use Proovit\Billing\Models\CreditNote;
use Proovit\FilamentBilling\Resources\CreditNoteResource\Pages\ManageCreditNotes;
use Proovit\FilamentBilling\Resources\CreditNoteResource\RelationManagers\LinesRelationManager;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class CreditNoteResource extends Resource
{
    protected static ?string $model = CreditNote::class;

    protected static ?string $slug = 'billing/credit-notes';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Credit note details')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('invoice_id')
                        ->label('Invoice')
                        ->relationship('invoice', 'number')
                        ->searchable()
                        ->preload(),
                    Select::make('status')
                        ->options(EnumOptions::from(CreditNoteStatus::class))
                        ->required(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('currency')->maxLength(3)->default('EUR'),
                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Credit note details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('invoice.number')->label('Invoice'),
                    TextEntry::make('status')->label('Status')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('number')->label('Number'),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('total_amount')->label('Total'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Number')->searchable()->sortable(),
                TextColumn::make('invoice.number')->label('Invoice')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('total_amount')->label('Total'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCreditNotes::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
        ];
    }
}
