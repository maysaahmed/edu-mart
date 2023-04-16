<?php

namespace Modules\Organizations\Infrastructure\Organization;

use App\Core\Repository\ICriteria;
use Illuminate\Database\Eloquent\Builder;

class OrderByLatest implements ICriteria
{
    public function apply(Builder $query): Builder
    {
        $query->orderByDesc('organization.id');
        return $query;
    }
}
