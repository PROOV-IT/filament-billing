<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\TaxRateResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\TaxRateResource;

final class ViewTaxRate extends ViewRecord
{
    protected static string $resource = TaxRateResource::class;
}
