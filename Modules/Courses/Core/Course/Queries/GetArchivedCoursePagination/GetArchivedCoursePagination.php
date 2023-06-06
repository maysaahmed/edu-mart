<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetArchivedCoursePagination implements IGetArchivedCoursePagination
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetArchivedCoursePaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getArchivedCoursesPagination($model);
    }
}
