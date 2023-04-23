<?php

namespace Modules\Courses\Core\Course\Commands\EditCourse;

use Modules\Courses\Domain\Entities\Course;

interface IEditCourse
{
    public function execute(EditCourseModel $model): Course;
}
