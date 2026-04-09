<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament\Schemas\InvoiceSeries;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Proovit\FilamentBilling\Support\Filament\EnumLabel;

final class InvoiceSeriesInfolistSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.sections.series_details'))
                ->schema([
                    TextEntry::make('company.legal_name')->label(__('filament-billing::filament-billing.resources.company.singular')),
                    TextEntry::make('establishment.name')->label(__('filament-billing::filament-billing.sections.establishment')),
                    TextEntry::make('document_type')->label(__('filament-billing::filament-billing.columns.document_type'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('name')->label(__('filament-billing::filament-billing.columns.name')),
                    TextEntry::make('prefix')->label(__('filament-billing::filament-billing.columns.prefix')),
                    TextEntry::make('suffix')->label(__('filament-billing::filament-billing.columns.suffix')),
                    TextEntry::make('pattern')->label(__('filament-billing::filament-billing.columns.pattern')),
                    TextEntry::make('padding')->label(__('filament-billing::filament-billing.columns.padding')),
                    TextEntry::make('reset_policy')->label(__('filament-billing::filament-billing.columns.type'))->formatStateUsing(static fn ($state): string => EnumLabel::make($state)),
                    TextEntry::make('current_sequence')->label(__('filament-billing::filament-billing.columns.current_sequence')),
                    TextEntry::make('is_default')->label(__('filament-billing::filament-billing.columns.default'))->formatStateUsing(static fn (bool $state): string => $state ? __('filament-billing::filament-billing.booleans.yes') : __('filament-billing::filament-billing.booleans.no')),
                ])
                ->columns(2),
        ]);
    }
}
