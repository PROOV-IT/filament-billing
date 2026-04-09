<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\CustomerResource;

final class ManageCustomers extends ManageRecords
{
    protected static string $resource = CustomerResource::class;
}
