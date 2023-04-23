<?php
namespace Modules\Courses\Core\Category\Queries\GetCategoryPagination;

use Modules\Courses\Core\Category\Repositories\ICategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetCategoryPagination implements IGetCategoryPagination
{
    private ICategoryRepository $repository;

    public function __construct(ICategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetCategoryPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getCategoriesPagination($model);
    }
}
