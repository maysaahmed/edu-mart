<?php
namespace Modules\Courses\Core\Course\Queries\GetCourses;

use Illuminate\Support\Collection;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class GetCourses implements IGetCourses
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getCourses();
    }
}
