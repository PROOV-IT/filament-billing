<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\CustomerResource;

final class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
