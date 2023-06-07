<?php
namespace Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetOrganizationCoursesPagination
{
    public function execute(GetOrganizationCoursesPaginationModel $model): LengthAwarePaginator;
}
