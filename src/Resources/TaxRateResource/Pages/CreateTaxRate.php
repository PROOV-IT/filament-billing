<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\TaxRateResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\TaxRateResource;

final class CreateTaxRate extends CreateRecord
{
    protected static string $resource = TaxRateResource::class;
}
