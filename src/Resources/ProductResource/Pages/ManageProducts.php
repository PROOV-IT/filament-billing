<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\ProductResource;

final class ManageProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;
}
