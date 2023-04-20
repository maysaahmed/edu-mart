<?php
namespace Modules\Courses\Core\Course\Queries\GetCourse;

use Modules\Courses\Domain\Entities\Course;

interface IGetCourse
{
    public function execute(int $id): Course|null;
}
