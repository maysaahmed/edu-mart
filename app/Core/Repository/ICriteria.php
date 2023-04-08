<?php

namespace App\Core\Repository;

use Illuminate\Database\Eloquent\Builder;

interface ICriteria
{
    public function apply(Builder $query): Builder;
}
