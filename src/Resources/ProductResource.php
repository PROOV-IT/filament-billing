<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Models\Product;
use Proovit\FilamentBilling\Resources\ProductResource\Pages\ManageProducts;
use Proovit\FilamentBilling\Resources\ProductResource\RelationManagers\PricesRelationManager;

final class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'billing/products';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Product details')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('sku')->maxLength(255),
                    TextInput::make('name')->required()->maxLength(255),
                    Textarea::make('description')->rows(4)->columnSpanFull(),
                    Select::make('currency')
                        ->options([
                            'EUR' => 'EUR',
                            'USD' => 'USD',
                            'GBP' => 'GBP',
                        ])
                        ->default('EUR')
                        ->required(),
                    Toggle::make('is_active')->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Product details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('sku')->label('SKU'),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('description')->label('Description')->columnSpanFull(),
                    TextEntry::make('currency')->label('Currency'),
                    TextEntry::make('is_active')->label('Active')->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('sku')->label('SKU')->searchable()->toggleable(),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->toggleable(),
                TextColumn::make('currency')->label('Currency')->badge(),
                IconColumn::make('is_active')->label('Active')->boolean(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('name');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProducts::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            PricesRelationManager::class,
        ];
    }
}
