<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament;

use BackedEnum;

final class EnumOptions
{
    /**
     * @param  class-string<BackedEnum>  $enumClass
     * @return array<string, string>
     */
    public static function from(string $enumClass): array
    {
        $options = [];

        foreach ($enumClass::cases() as $case) {
            $label = method_exists($case, 'label') ? $case->label() : $case->name;

            $options[(string) $case->value] = $label;
        }

        return $options;
    }
}
