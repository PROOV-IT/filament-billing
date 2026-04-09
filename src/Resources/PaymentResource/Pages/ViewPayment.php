<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\PaymentResource;

final class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;
}
