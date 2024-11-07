<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCourses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetArchivedCourses
{
    public function execute(GetArchivedCoursesModel $model): LengthAwarePaginator;
}
