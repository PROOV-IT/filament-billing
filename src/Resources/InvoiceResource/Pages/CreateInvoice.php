<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\InvoiceResource;

final class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
