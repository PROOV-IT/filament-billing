<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\ProductResource;

final class ManageProducts extends ManageRecords
{
    protected static string $resource = ProductResource::class;
}
