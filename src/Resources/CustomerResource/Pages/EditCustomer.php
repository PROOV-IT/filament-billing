<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CustomerResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\CustomerResource;

final class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;
}
