<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\QuoteResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Proovit\FilamentBilling\Resources\QuoteResource;

final class ManageQuotes extends ManageRecords
{
    protected static string $resource = QuoteResource::class;
}
