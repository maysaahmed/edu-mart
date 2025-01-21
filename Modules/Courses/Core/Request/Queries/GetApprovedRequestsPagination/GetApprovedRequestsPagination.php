<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination;

use Illuminate\Support\Collection;
use Modules\Courses\Core\Request\Repositories\IRequestRepository;


class GetApprovedRequestsPagination implements IGetApprovedRequestsPagination
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetApprovedRequestsPaginationModel $model): Collection
    {
        return $this->repository->getApprovedRequestsPagination($model);
    }
}
