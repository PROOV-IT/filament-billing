<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\Billing\Enums\InvoiceType;
use Proovit\Billing\Enums\SequenceResetPolicy;
use Proovit\Billing\Models\InvoiceSeries;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages\ManageInvoiceSeries;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class InvoiceSeriesResource extends Resource
{
    protected static ?string $model = InvoiceSeries::class;

    protected static ?string $slug = 'billing/series';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-hashtag';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Series details')
                ->schema([
                    TextEntry::make('company.legal_name')->label('Company'),
                    TextEntry::make('establishment.name')->label('Establishment'),
                    TextEntry::make('document_type')->label('Document type')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('prefix')->label('Prefix'),
                    TextEntry::make('suffix')->label('Suffix'),
                    TextEntry::make('pattern')->label('Pattern'),
                    TextEntry::make('padding')->label('Padding'),
                    TextEntry::make('reset_policy')->label('Reset policy')->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                    TextEntry::make('current_sequence')->label('Current sequence'),
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
                TextColumn::make('document_type')->label('Type')->badge()->formatStateUsing(static fn ($state): string => is_object($state) && method_exists($state, 'label') ? $state->label() : (string) $state),
                TextColumn::make('company.legal_name')->label('Company')->searchable()->toggleable(),
                TextColumn::make('establishment.name')->label('Establishment')->toggleable(),
                TextColumn::make('pattern')->label('Pattern')->toggleable(),
                TextColumn::make('current_sequence')->label('Sequence')->sortable(),
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
            'index' => ManageInvoiceSeries::route('/'),
        ];
    }
}
