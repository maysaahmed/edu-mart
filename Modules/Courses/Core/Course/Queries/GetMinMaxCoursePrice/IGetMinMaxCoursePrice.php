<?php
namespace Modules\Courses\Core\Course\Queries\GetMinMaxCoursePrice;

interface IGetMinMaxCoursePrice
{
    public function execute(int $org_id): array|null;
}
