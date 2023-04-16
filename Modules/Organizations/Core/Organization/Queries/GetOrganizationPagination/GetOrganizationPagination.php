<?php
namespace Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetOrganizationPagination implements IGetOrganizationPagination
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetOrganizationPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getOrganizationsPagination($model);
    }
}
