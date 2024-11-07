<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCourses;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class GetArchivedCourses implements IGetArchivedCourses
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetArchivedCoursesModel $model): LengthAwarePaginator
    {
        return $this->repository->getArchivedCourses($model);
    }
}
