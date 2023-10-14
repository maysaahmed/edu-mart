<?php
namespace Modules\Courses\Core\Course\Queries\GetMinMaxCoursePrice;

interface IGetMinMaxCoursePrice
{
    public function execute(): array|null;
}
