<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\TaxRateResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\TaxRateResource;

final class ManageTaxRates extends ListRecords
{
    protected static string $resource = TaxRateResource::class;
}
