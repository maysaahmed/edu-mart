<?php
namespace Modules\Courses\Core\Course\Queries\GetRecommendedCourses;

use Illuminate\Database\Eloquent\Collection;

interface IGetRecommendedCourses
{
    public function execute(): Collection;
}
