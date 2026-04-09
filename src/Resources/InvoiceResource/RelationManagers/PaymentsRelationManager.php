<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Proovit\Billing\Enums\PaymentMethodType;
use Proovit\Billing\Enums\PaymentStatus;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;

final class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'reference';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-billing::filament-billing.resources.payment.plural');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.payment'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('customer_id')
                        ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                        ->relationship('customer', 'legal_name')
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
                ])
                ->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label(__('filament-billing::filament-billing.columns.reference'))->searchable()->toggleable(),
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge(),
                TextColumn::make('method')->label(__('filament-billing::filament-billing.columns.type'))->badge()->toggleable(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                TextColumn::make('paid_at')->label(__('filament-billing::filament-billing.columns.paid_at'))->date()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
