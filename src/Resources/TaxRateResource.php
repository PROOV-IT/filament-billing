<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
use Proovit\Billing\Models\TaxRate;

final class TaxRateResource extends Resource
{
    protected static ?string $model = TaxRate::class;

    protected static ?string $slug = 'billing/tax-rates';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tax rate')
                ->schema([
                    Select::make('company_id')
                        ->label('Company')
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('rate')->numeric()->step(0.0001)->required(),
                    TextInput::make('country')->maxLength(2)->default('FR'),
                    Toggle::make('is_default')->default(false),
                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tax rate')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('rate')->label('Rate'),
                    TextEntry::make('country')->label('Country'),
                    TextEntry::make('is_default')->label('Default')->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('rate')->label('Rate')->formatStateUsing(static fn ($state): string => rtrim(rtrim(number_format((float) $state, 4, '.', ''), '0'), '.').'%'),
                TextColumn::make('country')->label('Country')->badge(),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->toggleable(),
                TextColumn::make('is_default')->label('Default')->badge()->formatStateUsing(static fn (bool $state): string => $state ? 'Yes' : 'No'),
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
            'index' => ListRecords::route('/'),
            'create' => CreateRecord::route('/create'),
            'view' => ViewRecord::route('/{record}'),
            'edit' => EditRecord::route('/{record}/edit'),
        ];
    }
}
