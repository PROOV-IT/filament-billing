<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;

final class CreateInvoiceSeries extends CreateRecord
{
    protected static string $resource = InvoiceSeriesResource::class;
}
