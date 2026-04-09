<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Proovit\Billing\Models\Product;
use Proovit\FilamentBilling\Resources\ProductResource;

final class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        $record = $this->record;

        if (! $record instanceof Product || $record->canEditCatalog()) {
            return;
        }

        throw new AuthorizationException(__('filament-billing::filament-billing.messages.product_locked'));
    }
}
