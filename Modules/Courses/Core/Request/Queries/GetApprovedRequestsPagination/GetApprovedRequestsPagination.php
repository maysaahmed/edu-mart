<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetApprovedRequestsPagination implements IGetApprovedRequestsPagination
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetApprovedRequestsPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getApprovedRequestsPagination($model);
    }
}
