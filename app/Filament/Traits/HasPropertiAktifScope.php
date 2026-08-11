<?php

namespace App\Filament\Traits;

use App\Services\PropertiContext;
use Illuminate\Database\Eloquent\Builder;

trait HasPropertiAktifScope
{
    /**
     * Apply active property scope to an Eloquent query builder.
     *
     * @param  Builder  $query  The query to modify
     * @param  string  $path  Path to properti_id.
     *                        If direct column, use 'properti_id'.
     *                        If via relation, use dotted path, e.g., 'tipeKamar.properti_id'
     *                        or 'sewa.kamar.tipeKamar.properti_id'
     */
    public static function applyPropertiAktifScope(Builder $query, string $path): Builder
    {
        $propertiId = app(PropertiContext::class)->currentId();

        if (! $propertiId) {
            // If no active property context (e.g. user has no access to any property), return empty
            return $query->whereRaw('1 = 0');
        }

        if (str_contains($path, '.')) {
            // It's a relationship path like 'sewa.kamar.tipeKamar.properti_id'
            $segments = explode('.', $path);
            $column = array_pop($segments);
            $relation = implode('.', $segments);

            return $query->whereHas($relation, function (Builder $q) use ($column, $propertiId) {
                $q->where($column, $propertiId);
            });
        }

        // Direct column
        return $query->where($path, $propertiId);
    }
}
