<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;

final class ViewInvoiceSeries extends ViewRecord
{
    protected static string $resource = InvoiceSeriesResource::class;
}
