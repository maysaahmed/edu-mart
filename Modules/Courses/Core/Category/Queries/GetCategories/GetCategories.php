<?php
namespace Modules\Courses\Core\Category\Queries\GetCategories;

use Modules\Courses\Core\Category\Repositories\ICategoryRepository;
use Illuminate\Support\Collection;

class GetCategories implements IGetCategories
{
    private ICategoryRepository $repository;

    public function __construct(ICategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getCategories();
    }
}
