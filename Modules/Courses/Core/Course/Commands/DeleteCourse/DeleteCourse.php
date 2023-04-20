<?php
namespace Modules\Courses\Core\Course\Commands\DeleteCourse;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;


class DeleteCourse implements IDeleteCourse
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getCourseById($id);

        if(!$item){
            throw new \Exception('Course cannot be found!');
        }

        $deleteItem = $this->repository->deleteCourse($id);

        if (!$deleteItem){
            throw new \Exception('Course failed to remove!');
        }

        return true;
    }
}
