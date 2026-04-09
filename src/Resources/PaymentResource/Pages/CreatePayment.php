<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\PaymentResource;

final class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}
