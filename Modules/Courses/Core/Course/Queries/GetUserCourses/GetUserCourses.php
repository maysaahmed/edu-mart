<?php
namespace Modules\Courses\Core\Course\Queries\GetUserCourses;

use Illuminate\Database\Eloquent\Collection;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class GetUserCourses implements IGetUserCourses
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUserCoursesModel $model): Collection
    {
        return $this->repository->getUserCourses($model);
    }
}
