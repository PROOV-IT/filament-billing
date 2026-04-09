<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceSeriesResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\InvoiceSeriesResource;

final class EditInvoiceSeries extends EditRecord
{
    protected static string $resource = InvoiceSeriesResource::class;
}
