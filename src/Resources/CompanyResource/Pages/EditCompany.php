<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Proovit\FilamentBilling\Resources\CompanyResource;

final class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;
}
