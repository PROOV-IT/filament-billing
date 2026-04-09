<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Proovit\FilamentBilling\Resources\CompanyResource;

final class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;
}
