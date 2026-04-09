<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Invoices;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Proovit\Billing\Models\Product;
use Proovit\Billing\Models\ProductPrice;
use Proovit\Billing\Models\TaxRate;
use Proovit\Billing\ValueObjects\Money;
use Proovit\FilamentBilling\Support\Filament\RecordLabel;

final class LinesRelationManagerFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.line_item'))
                ->schema([
                    TextInput::make('sort_order')->numeric()->default(0)->required(),
                    Select::make('product_id')
                        ->label(__('filament-billing::filament-billing.columns.product'))
                        ->relationship('product', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (Product $record): string => RecordLabel::make($record, ['name', 'sku']))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            self::prefillFromProduct($set, $state);
                            self::recalculateTotals($set, $get);
                        }),
                    Select::make('tax_rate_id')
                        ->label(__('filament-billing::filament-billing.resources.tax_rate.singular'))
                        ->relationship('taxRate', 'name')
                        ->getOptionLabelFromRecordUsing(static fn (TaxRate $record): string => RecordLabel::make($record, ['name', 'rate']))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, mixed $state): void {
                            self::prefillFromTaxRate($set, $state);
                            self::recalculateTotals($set, $get);
                        }),
                    TextInput::make('description')->required()->columnSpanFull(),
                    TextInput::make('quantity')
                        ->numeric()
                        ->default(1)
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get): void {
                            self::recalculateTotals($set, $get);
                        }),
                    TextInput::make('unit_price')
                        ->numeric()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get): void {
                            self::recalculateTotals($set, $get);
                        }),
                    TextInput::make('discount_amount')
                        ->numeric()
                        ->default(0)
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get): void {
                            self::recalculateTotals($set, $get);
                        }),
                    TextInput::make('tax_rate')
                        ->numeric()
                        ->default(0)
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get): void {
                            self::recalculateTotals($set, $get);
                        }),
                    TextInput::make('subtotal_amount')->numeric()->default(0)->readOnly(),
                    TextInput::make('tax_amount')->numeric()->default(0)->readOnly(),
                    TextInput::make('total_amount')->numeric()->default(0)->readOnly(),
                ])
                ->columns(2),
        ]);
    }

    private static function prefillFromProduct(Set $set, mixed $state): void
    {
        if (blank($state)) {
            return;
        }

        $product = Product::query()
            ->with(['prices.taxRate'])
            ->find($state);

        if (! $product instanceof Product) {
            return;
        }

        $set('description', (string) ($product->name ?? ''));

        $price = $product->prices
            ->sortByDesc('starts_at')
            ->first();

        if ($price instanceof ProductPrice) {
            $set('unit_price', (string) $price->getAttribute('amount'));

            if ($price->taxRate instanceof TaxRate) {
                $set('tax_rate_id', $price->getAttribute('tax_rate_id'));
                $set('tax_rate', (string) $price->taxRate->getAttribute('rate'));
            }
        }
    }

    private static function prefillFromTaxRate(Set $set, mixed $state): void
    {
        if (blank($state)) {
            return;
        }

        $taxRate = TaxRate::query()->find($state);

        if (! $taxRate instanceof TaxRate) {
            return;
        }

        $set('tax_rate', (string) $taxRate->getAttribute('rate'));
    }

    private static function recalculateTotals(Set $set, Get $get): void
    {
        $currency = 'EUR';
        $quantity = (string) ($get('quantity') ?: '0');
        $unitPrice = Money::fromDecimal((string) ($get('unit_price') ?: '0'), $currency);
        $discount = Money::fromDecimal((string) ($get('discount_amount') ?: '0'), $currency);
        $taxRate = (float) ($get('tax_rate') ?: 0);

        $subtotal = $unitPrice->multipliedBy($quantity);

        if (! $discount->isZero()) {
            $subtotal = $subtotal->minus($discount);
        }

        $taxAmount = Money::fromDecimal(
            (string) (round((float) $subtotal->amount * ($taxRate / 100), 2)),
            $currency,
        );

        $set('subtotal_amount', $subtotal->toDecimalString());
        $set('tax_amount', $taxAmount->toDecimalString());
        $set('total_amount', $subtotal->plus($taxAmount)->toDecimalString());
    }
}
