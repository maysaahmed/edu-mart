<?php
namespace Modules\Courses\Core\Category\Commands\EditCategory;

use Modules\Courses\Core\Category\Repositories\ICategoryRepository;
use Modules\Courses\Domain\Entities\Category;

class EditCategory implements IEditCategory
{
    private ICategoryRepository $repository;

    public function __construct(ICategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditCategoryModel $model): Category
    {
        $item =$this->repository->getCategoryById($model->id);

        if(!$item){
            throw new \Exception('Category cannot be found!');
        }

        $updatedItem = $this->repository->editCategory($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Category failed to update!');
    }
}
