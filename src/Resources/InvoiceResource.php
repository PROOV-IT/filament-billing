<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\InvoiceStatus;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Resources\InvoiceResource\Pages\ManageInvoices;
use Proovit\FilamentBilling\Resources\InvoiceResource\RelationManagers\LinesRelationManager;
use Proovit\FilamentBilling\Resources\InvoiceResource\RelationManagers\PaymentsRelationManager;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $slug = 'billing/invoices';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document details')
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
                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'legal_name')
                        ->searchable()
                        ->preload(),
                    Select::make('invoice_series_id')
                        ->label('Series')
                        ->relationship('series', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('document_type')
                        ->options(EnumOptions::from(InvoiceType::class))
                        ->required(),
                    Select::make('status')
                        ->options(EnumOptions::from(InvoiceStatus::class))
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
                    DatePicker::make('issued_at'),
                    DatePicker::make('due_at'),
                    DatePicker::make('finalized_at'),
                    DatePicker::make('cancelled_at'),
                    Textarea::make('notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('establishment.name')->label('Establishment'),
                    TextEntry::make('customer.legal_name')->label('Customer'),
                    TextEntry::make('series.name')->label('Series'),
                    TextEntry::make('document_type')->label('Type')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('status')->label('Status')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('number')->label('Number'),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('issued_at')->label('Issued at'),
                    TextEntry::make('due_at')->label('Due at'),
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
                TextColumn::make('document_type')->label('Type')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('issued_at')->label('Issued')->date()->sortable()->toggleable(),
                TextColumn::make('due_at')->label('Due')->date()->toggleable(),
                TextColumn::make('total_amount')->label('Total')->formatStateUsing(static fn ($state, Invoice $record): string => number_format((float) $state, 2, ',', ' ').' '.($record->currency ?? 'EUR')),
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
            'index' => ManageInvoices::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LinesRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }
}
