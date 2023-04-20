<?php

namespace Modules\Courses\Core\Course\Commands\CreateCourse;

use Modules\Courses\Domain\Entities\Course;

interface ICreateCourse
{
    public function execute(CreateCourseModel $model): Course;
}
