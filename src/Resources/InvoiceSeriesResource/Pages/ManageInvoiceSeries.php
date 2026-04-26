<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;

final class ManageInvoiceSeries extends ListRecords
{
    protected static string $resource = InvoiceSeriesResource::class;
}
