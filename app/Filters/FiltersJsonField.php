<?php
namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FiltersJsonField implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        $locales = getLocales();
        return $query->WhereRaw("LOWER({$property}->>'$.$locales[0]') LIKE ?", ['%' . strtolower($value) . '%'])
            ->orWhereRaw("LOWER({$property}->>'$.$locales[1]') LIKE ?", ['%' . strtolower($value) . '%']);
    }
}
