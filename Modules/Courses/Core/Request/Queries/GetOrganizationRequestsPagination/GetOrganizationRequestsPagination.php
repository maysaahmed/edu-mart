<?php
namespace Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetOrganizationRequestsPagination implements IGetOrganizationRequestsPagination
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetOrganizationRequestsPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getOrganizationRequestsPagination($model);
    }
}
