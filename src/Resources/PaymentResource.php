<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Proovit\Billing\Models\Payment;
use Proovit\FilamentBilling\Resources\PaymentResource\Pages\ManagePayments;
use Proovit\FilamentBilling\Resources\PaymentResource\RelationManagers\AllocationsRelationManager;
use Proovit\FilamentBilling\Support\Filament\Schemas\Payments\PaymentFormSchema;
use Proovit\FilamentBilling\Support\Filament\Schemas\Payments\PaymentInfolistSchema;
use Proovit\FilamentBilling\Support\Filament\Tables\Payments\PaymentTable;

final class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $slug = 'billing/payments';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.payment.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-billing::filament-billing.resources.payment.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return PaymentFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaymentInfolistSchema::make($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentTable::make($table);
    }

    public static function getNavigationGroup(): string
    {
        return (string) __('filament-billing::filament-billing.navigation.group');
    }

    public static function getRelations(): array
    {
        return [
            AllocationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePayments::route('/'),
        ];
    }
}
