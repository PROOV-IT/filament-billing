<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\PaymentResource;

final class ManagePayments extends ManageRecords
{
    protected static string $resource = PaymentResource::class;
}
