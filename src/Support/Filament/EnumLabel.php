<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament;

use BackedEnum;

final class EnumLabel
{
    public static function make(mixed $state, ?string $fallback = null): string
    {
        if ($state instanceof BackedEnum) {
            if (method_exists($state, 'label')) {
                return (string) $state->label();
            }

            return (string) $state->name;
        }

        if (is_object($state) && method_exists($state, 'label')) {
            return (string) $state->label();
        }

        if (is_scalar($state)) {
            return (string) $state;
        }

        return $fallback ?? '';
    }
}
