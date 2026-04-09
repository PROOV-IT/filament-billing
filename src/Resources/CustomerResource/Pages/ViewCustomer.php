<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\CustomerResource;

final class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;
}
