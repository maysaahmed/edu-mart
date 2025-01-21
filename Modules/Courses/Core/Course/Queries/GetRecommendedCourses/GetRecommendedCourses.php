<?php
namespace Modules\Courses\Core\Course\Queries\GetRecommendedCourses;

use Illuminate\Database\Eloquent\Collection;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class GetRecommendedCourses implements IGetRecommendedCourses
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        $user_id = auth()->id();
        return $this->repository->getRecommendedCourses($user_id);
    }
}
