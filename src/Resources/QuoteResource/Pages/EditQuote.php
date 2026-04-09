<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\QuoteResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\QuoteResource;

final class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;
}
