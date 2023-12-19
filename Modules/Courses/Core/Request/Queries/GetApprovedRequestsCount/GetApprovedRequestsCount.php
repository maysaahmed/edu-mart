<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsCount;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;

class GetApprovedRequestsCount implements IGetApprovedRequestsCount
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): int
    {
        return $this->repository->getApprovedRequestsCount();
    }
}
