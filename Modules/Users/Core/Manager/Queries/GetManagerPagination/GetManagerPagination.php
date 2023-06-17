<?php
namespace Modules\Users\Core\Manager\Queries\GetManagerPagination;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetManagerPagination implements IGetManagerPagination
{
    public function __construct(
        private IManagerRepository $repository
    )
    {
    }

    public function execute(GetManagerPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getManagersPagination($model);
    }
}
