<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\InvoiceResource;

final class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;
}
