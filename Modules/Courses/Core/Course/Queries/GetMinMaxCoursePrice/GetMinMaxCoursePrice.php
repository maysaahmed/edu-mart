<?php
namespace Modules\Courses\Core\Course\Queries\GetMinMaxCoursePrice;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class GetMinMaxCoursePrice implements IGetMinMaxCoursePrice
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array|null
    {
        return $this->repository->getMinMaxCoursePrice();
    }
}
