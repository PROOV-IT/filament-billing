<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\ProductResource;

final class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
