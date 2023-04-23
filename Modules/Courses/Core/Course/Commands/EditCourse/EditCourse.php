<?php
namespace Modules\Courses\Core\Course\Commands\EditCourse;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Modules\Courses\Domain\Entities\Course;

class EditCourse implements IEditCourse
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditCourseModel $model): Course
    {
        $item =$this->repository->getCourseById($model->id);

        if(!$item){
            throw new \Exception('Course cannot be found!');
        }

        $updatedItem = $this->repository->editCourse($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Course failed to update!');
    }
}
