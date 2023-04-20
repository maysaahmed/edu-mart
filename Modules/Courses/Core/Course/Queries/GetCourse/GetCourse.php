<?php
namespace Modules\Courses\Core\Course\Queries\GetCourse;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Modules\Courses\Domain\Entities\Course;

class GetCourse implements IGetCourse
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): Course|null
    {
        return $this->repository->getCourseById($id);
    }
}
