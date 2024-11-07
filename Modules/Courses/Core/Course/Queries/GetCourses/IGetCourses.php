<?php
namespace Modules\Courses\Core\Course\Queries\GetCourses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetCourses
{
    public function execute(GetCoursesModel $model): LengthAwarePaginator;
}
