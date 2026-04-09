<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\QuoteStatus;
use Proovit\Billing\Models\Quote;
use Proovit\FilamentBilling\Resources\QuoteResource\Pages\ManageQuotes;
use Proovit\FilamentBilling\Resources\QuoteResource\RelationManagers\LinesRelationManager;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $slug = 'billing/quotes';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Quote details')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('customer_id')
                        ->label('Customer')
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Quote details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('customer.legal_name')->label('Customer'),
                    TextEntry::make('status')->label('Status')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('number')->label('Number'),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('total_amount')->label('Total'),
                    TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Number')->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : 'Draft'),
                TextColumn::make('issued_at')->label('Issued')->date()->sortable()->toggleable(),
                TextColumn::make('total_amount')->label('Total')->formatStateUsing(static fn ($state, Quote $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
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
            'index' => ManageQuotes::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
        ];
    }
}
