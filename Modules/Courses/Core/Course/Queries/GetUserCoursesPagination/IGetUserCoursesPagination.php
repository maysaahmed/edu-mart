<?php
namespace Modules\Courses\Core\Course\Queries\GetUserCoursesPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetUserCoursesPagination
{
    public function execute(GetUserCoursesPaginationModel $model): LengthAwarePaginator;
}
