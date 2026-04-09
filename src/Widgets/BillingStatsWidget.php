<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Proovit\FilamentBilling\Support\BillingOverviewMetrics;

final class BillingStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Billing overview';

    protected ?string $description = 'Live snapshot of the billing core.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return array_map(
            static fn (array $stat): Stat => Stat::make($stat['label'], $stat['value'])
                ->description($stat['hint'])
                ->color('primary'),
            app(BillingOverviewMetrics::class)->stats(),
        );
    }
}
