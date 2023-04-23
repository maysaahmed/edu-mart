<?php
namespace Modules\Courses\Core\Category\Commands\CreateCategory;

use Modules\Courses\Core\Category\Repositories\ICategoryRepository;
use Modules\Courses\Domain\Entities\Category;

class CreateCategory implements ICreateCategory
{
    private ICategoryRepository $repository;

    public function __construct(ICategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name): Category
    {
        return $this->repository->createCategory($name);
    }
}
