<?php
namespace Modules\Courses\Core\Category\Commands\DeleteCategory;

use Modules\Courses\Core\Category\Repositories\ICategoryRepository;
use Modules\Courses\Domain\Entities\Category;

class DeleteCategory implements IDeleteCategory
{
    private ICategoryRepository $repository;

    public function __construct(ICategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getCategoryById($id);

        if(!$item){
            throw new \Exception('Category cannot be found!');
        }

        $deleteItem = $this->repository->deleteCategory($id);

        if (!$deleteItem){
            throw new \Exception('Category failed to remove!');
        }

        return true;
    }
}
