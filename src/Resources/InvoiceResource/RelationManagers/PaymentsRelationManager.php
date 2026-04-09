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
use Proovit\Billing\Models\Company;
use Proovit\Billing\Models\Customer;
use Proovit\Billing\Models\Invoice;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;
use Proovit\FilamentBilling\Support\Filament\EnumOptions;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

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
        $ownerRecord = $this->getOwnerRecord();

        if (! $ownerRecord instanceof Invoice) {
            return $schema;
        }

        $defaultCompanyId = $ownerRecord->company?->getKey();
        $defaultCustomerId = $ownerRecord->customer?->getKey();
        $defaultCurrency = (string) ($ownerRecord->currency ?? 'EUR');
        $paidAmount = (float) $ownerRecord->payments()->sum('amount');
        $defaultAmount = number_format(max(0, (float) ($ownerRecord->total_amount ?? 0) - $paidAmount), 2, '.', '');

        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.payment'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('filament-billing::filament-billing.resources.company.singular'))
                        ->relationship('company', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Company $record): string => RecordLabel::make($record, ['legal_name', 'display_name', 'name']))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->default($defaultCompanyId),
                    Select::make('customer_id')
                        ->label(__('filament-billing::filament-billing.resources.customer.singular'))
                        ->relationship('customer', 'legal_name')
                        ->getOptionLabelFromRecordUsing(static fn (Customer $record): string => RecordLabel::make($record, ['legal_name', 'full_name', 'reference']))
                        ->searchable()
                        ->preload()
                        ->default($defaultCustomerId),
                    Select::make('status')
                        ->options(EnumOptions::from(PaymentStatus::class))
                        ->required(),
                    Select::make('method')
                        ->options(EnumOptions::from(PaymentMethodType::class)),
                    TextInput::make('currency')->maxLength(3)->default($defaultCurrency),
                    TextInput::make('amount')->numeric()->required()->default($defaultAmount),
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
                TextColumn::make('status')->label(__('filament-billing::filament-billing.columns.status'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                TextColumn::make('method')->label(__('filament-billing::filament-billing.columns.type'))->badge()->formatStateUsing(static fn ($state): string => EnumLabel::make($state))->toggleable(),
                TextColumn::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                TextColumn::make('paid_at')->label(__('filament-billing::filament-billing.columns.paid_at'))->date()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
