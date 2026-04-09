<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Payments;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class PaymentInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.payment_details'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('customer.legal_name')->label(__('filament-billing::filament-billing.resources.customer.singular')),
                    TextEntry::make('invoice.number')->label(__('filament-billing::filament-billing.resources.invoice.singular')),
                    TextEntry::make('status')->label(__('filament-billing::filament-billing.columns.status'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('method')->label(__('filament-billing::filament-billing.columns.type'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('currency')->label(__('filament-billing::filament-billing.columns.currency')),
                    TextEntry::make('amount')->label(__('filament-billing::filament-billing.columns.total')),
                    TextEntry::make('paid_at')->label(__('filament-billing::filament-billing.columns.paid_at')),
                    TextEntry::make('reference')->label(__('filament-billing::filament-billing.columns.reference')),
                    TextEntry::make('notes')->label(__('filament-billing::filament-billing.columns.notes'))->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
