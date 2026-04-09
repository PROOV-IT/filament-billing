<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\PaymentResource;

final class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;
}
