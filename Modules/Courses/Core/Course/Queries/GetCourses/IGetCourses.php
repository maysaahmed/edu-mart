<?php
namespace Modules\Courses\Core\Course\Queries\GetCourses;

use Illuminate\Support\Collection;

interface IGetCourses
{
    public function execute(): Collection;
}
