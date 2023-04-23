<?php
namespace Modules\Courses\Core\Provider\Queries\GetProviderPagination;

use Modules\Courses\Core\Provider\Repositories\IProviderRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetProviderPagination implements IGetProviderPagination
{
    private IProviderRepository $repository;

    public function __construct(IProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetProviderPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getProvidersPagination($model);
    }
}
