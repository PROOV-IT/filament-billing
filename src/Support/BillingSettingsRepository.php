<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support;

use Illuminate\Support\Facades\Cache;
use Throwable;

final class BillingSettingsRepository
{
    private const CACHE_KEY = 'filament-billing.settings';

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        $defaults = config('filament-billing', []);

        try {
            $overrides = Cache::get(self::CACHE_KEY, []);
        } catch (Throwable) {
            $overrides = [];
        }

        return array_replace_recursive($defaults, is_array($overrides) ? $overrides : []);
    }

    /**
     * @param  array<string, mixed>  $settings
     */
    public function save(array $settings): bool
    {
        try {
            Cache::forever(self::CACHE_KEY, $this->prune($settings));

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @param  array<string, mixed>  $settings
     * @return array<string, mixed>
     */
    private function prune(array $settings): array
    {
        $filtered = [];

        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                $nested = $this->prune($value);

                if ($nested !== []) {
                    $filtered[$key] = $nested;
                }

                continue;
            }

            if ($value === null || $value === '') {
                continue;
            }

            $filtered[$key] = $value;
        }

        return $filtered;
    }
}
