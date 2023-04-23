<?php
namespace Modules\Courses\Core\Course\Commands\CreateCourse;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Modules\Courses\Domain\Entities\Course;

class CreateCourse implements ICreateCourse
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateCourseModel $model): Course
    {
        return $this->repository->createCourse($model);
    }
}
