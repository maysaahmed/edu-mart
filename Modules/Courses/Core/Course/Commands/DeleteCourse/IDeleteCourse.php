<?php

namespace Modules\Courses\Core\Course\Commands\DeleteCourse;

interface IDeleteCourse
{
    public function execute(int $id): bool;
}
