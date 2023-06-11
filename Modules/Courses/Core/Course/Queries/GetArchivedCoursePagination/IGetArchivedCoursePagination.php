<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetArchivedCoursePagination
{
    public function execute(GetArchivedCoursePaginationModel $model): LengthAwarePaginator;
}
