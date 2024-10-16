<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCourses;

use Illuminate\Support\Collection;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class GetArchivedCourses implements IGetArchivedCourses
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getArchivedCourses();
    }
}
