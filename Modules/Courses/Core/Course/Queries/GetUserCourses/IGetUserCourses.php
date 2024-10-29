<?php
namespace Modules\Courses\Core\Course\Queries\GetUserCourses;

use Illuminate\Database\Eloquent\Collection;

interface IGetUserCourses
{
    public function execute(GetUserCoursesModel $model): Collection;
}
