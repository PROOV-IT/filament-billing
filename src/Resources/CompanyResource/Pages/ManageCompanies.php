<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Resources\CompanyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Proovit\FilamentBilling\Resources\CompanyResource;

final class ManageCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;
}
