<?php
namespace Modules\Courses\Core\Course\Queries\GetCoursePagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetCoursePagination
{
    public function execute(GetCoursePaginationModel $model): LengthAwarePaginator;
}
