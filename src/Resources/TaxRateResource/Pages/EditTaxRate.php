<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\TaxRateResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\TaxRateResource;

final class EditTaxRate extends EditRecord
{
    protected static string $resource = TaxRateResource::class;
}
