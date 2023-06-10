<?php
namespace Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetOrganizationCoursesPagination implements IGetOrganizationCoursesPagination
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetOrganizationCoursesPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getOrganizationCoursesPagination($model);
    }
}
