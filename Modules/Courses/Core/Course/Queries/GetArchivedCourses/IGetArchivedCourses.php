<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCourses;

use Illuminate\Support\Collection;

interface IGetArchivedCourses
{
    public function execute(): Collection;
}
