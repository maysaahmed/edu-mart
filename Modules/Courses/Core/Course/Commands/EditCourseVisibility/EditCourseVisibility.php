<?php
namespace Modules\Courses\Core\Course\Commands\EditCourseVisibility;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class EditCourseVisibility implements IEditCourseVisibility
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($course_id, $org_id): bool
    {
        $item =$this->repository->getCourseById($course_id);

        if(!$item){
            throw new \Exception('Course cannot be found!');
        }

        $updated = $this->repository->editCourseVisibility($course_id, $org_id);

        if ($updated){
            return $updated;
        }

        throw new \Exception('Course visibility failed to update!');
    }
}
