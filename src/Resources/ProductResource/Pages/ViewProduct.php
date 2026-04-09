<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\ProductResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\ProductResource;

final class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;
}
