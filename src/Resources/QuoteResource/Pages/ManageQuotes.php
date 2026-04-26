<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\QuoteResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\QuoteResource;

final class ManageQuotes extends ListRecords
{
    protected static string $resource = QuoteResource::class;
}
