<?php
namespace Modules\Courses\Core\Level\Queries\GetLevelPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetLevelPagination
{
    public function execute(GetLevelPaginationModel $model): LengthAwarePaginator;
}
