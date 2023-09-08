<?php
namespace Modules\Courses\Core\Course\Queries\GetUserCoursesPagination;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUserCoursesPagination implements IGetUserCoursesPagination
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUserCoursesPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getUserCoursesPagination($model);
    }
}
