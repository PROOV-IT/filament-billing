<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\PaymentResource;

final class ManagePayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
