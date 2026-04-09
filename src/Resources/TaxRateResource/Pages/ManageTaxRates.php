<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\TaxRateResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\TaxRateResource;

final class ManageTaxRates extends ManageRecords
{
    protected static string $resource = TaxRateResource::class;
}
