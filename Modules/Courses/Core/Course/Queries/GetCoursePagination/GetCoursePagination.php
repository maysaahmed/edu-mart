<?php
namespace Modules\Courses\Core\Course\Queries\GetCoursePagination;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetCoursePagination implements IGetCoursePagination
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetCoursePaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getCoursesPagination($model);
    }
}
