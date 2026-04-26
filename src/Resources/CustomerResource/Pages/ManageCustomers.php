<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\CustomerResource;

final class ManageCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;
}
