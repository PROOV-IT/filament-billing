<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;

final class ManageInvoiceSeries extends ManageRecords
{
    protected static string $resource = InvoiceSeriesResource::class;
}
