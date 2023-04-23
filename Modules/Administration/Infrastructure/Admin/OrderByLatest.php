<?php

namespace Modules\Administration\Infrastructure\Admin;

use App\Core\Repository\ICriteria;
use Illuminate\Database\Eloquent\Builder;

class OrderByLatest implements ICriteria
{
    public function apply(Builder $query): Builder
    {
        $query->orderByDesc('users.id');
        return $query;
    }
}
