<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\Payments;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class PaymentInfolistSchema
{
    public static function make(Schema $schema): Schema
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
}
