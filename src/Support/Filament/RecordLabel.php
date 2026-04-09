<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Support\Filament;

use Illuminate\Database\Eloquent\Model;

final class RecordLabel
{
    /**
     * @param  array<int, string>  $attributes
     */
    public static function make(Model $record, array $attributes = ['name']): string
    {
        foreach ($attributes as $attribute) {
            $value = $record->getAttribute($attribute);

            if (filled($value)) {
                return (string) $value;
            }
        }

        return sprintf('%s #%s', class_basename($record), (string) $record->getRouteKey());
    }
}
