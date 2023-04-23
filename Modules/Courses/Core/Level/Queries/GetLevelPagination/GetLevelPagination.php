<?php
namespace Modules\Courses\Core\Level\Queries\GetLevelPagination;

use Modules\Courses\Core\Level\Repositories\ILevelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetLevelPagination implements IGetLevelPagination
{
    private ILevelRepository $repository;

    public function __construct(ILevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetLevelPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getLevelsPagination($model);
    }
}
