<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\InvoiceResource;

final class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;
}
