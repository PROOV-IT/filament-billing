<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CreditNoteResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\CreditNoteResource;

final class ManageCreditNotes extends ManageRecords
{
    protected static string $resource = CreditNoteResource::class;
}
