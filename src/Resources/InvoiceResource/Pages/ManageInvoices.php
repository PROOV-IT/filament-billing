<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\InvoiceResource;

final class ManageInvoices extends ManageRecords
{
    protected static string $resource = InvoiceResource::class;
}
