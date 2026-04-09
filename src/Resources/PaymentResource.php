<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\PaymentMethodType;
use Proovit\Billing\Enums\PaymentStatus;
use Proovit\Billing\Models\Payment;
use Proovit\FilamentBilling\Resources\PaymentResource\RelationManagers\AllocationsRelationManager;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $slug = 'billing/payments';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Payment details')
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
                    Select::make('invoice_id')
                        ->label('Invoice')
                        ->relationship('invoice', 'number')
                        ->searchable()
                        ->preload(),
                    Select::make('status')
                        ->options(EnumOptions::from(PaymentStatus::class))
                        ->required(),
                    Select::make('method')
                        ->options(EnumOptions::from(PaymentMethodType::class)),
                    TextInput::make('currency')->maxLength(3)->default('EUR'),
                    TextInput::make('amount')->numeric()->required(),
                    DatePicker::make('paid_at'),
                    TextInput::make('reference')->maxLength(255),
                    Textarea::make('notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Payment details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('customer.legal_name')->label('Customer'),
                    TextEntry::make('invoice.number')->label('Invoice'),
                    TextEntry::make('status')->label('Status')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('method')->label('Method')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('amount')->label('Amount'),
                    TextEntry::make('paid_at')->label('Paid at'),
                    TextEntry::make('reference')->label('Reference'),
                    TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label('Invoice')->searchable()->sortable(),
                TextColumn::make('customer.legal_name')->label('Customer')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('method')->label('Method')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state)->toggleable(),
                TextColumn::make('amount')->label('Amount'),
                TextColumn::make('paid_at')->label('Paid at')->date()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getRelations(): array
    {
        return [
            AllocationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRecords::route('/'),
            'create' => CreateRecord::route('/create'),
            'view' => ViewRecord::route('/{record}'),
            'edit' => EditRecord::route('/{record}/edit'),
        ];
    }
}
