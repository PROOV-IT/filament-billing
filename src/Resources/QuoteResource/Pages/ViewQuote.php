<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\QuoteResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Proovit\FilamentBilling\Resources\QuoteResource;

final class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;
}
