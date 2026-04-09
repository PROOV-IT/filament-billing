<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\RelationManagers\Customers;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class AddressesRelationManagerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->badge()->formatStateUsing(static fn ($state): string => match ($state) {
                    'billing' => __('filament-billing::filament-billing.columns.type_billing'),
                    'shipping' => __('filament-billing::filament-billing.columns.type_shipping'),
                    'other' => __('filament-billing::filament-billing.columns.type_other'),
                    default => EnumLabel::make($state),
                }),
                TextColumn::make('line1')->label(__('filament-billing::filament-billing.sections.address'))->searchable()->sortable(),
                TextColumn::make('postal_code')->label(__('filament-billing::filament-billing.columns.postal_code'))->toggleable(),
                TextColumn::make('city')->label(__('filament-billing::filament-billing.columns.city'))->toggleable(),
                TextColumn::make('country')->label(__('filament-billing::filament-billing.columns.country'))->toggleable(),
                TextColumn::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->badge()->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
            ])
            ->defaultSort('is_default', 'desc');
    }
}
