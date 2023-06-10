<?php

namespace Modules\Courses\Core\Course\Commands\EditCourseVisibility;


interface IEditCourseVisibility
{
    public function execute(int $course_id, int $org_id): bool;
}
