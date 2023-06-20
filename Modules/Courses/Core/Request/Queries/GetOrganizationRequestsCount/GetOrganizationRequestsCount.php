<?php
namespace Modules\Courses\Core\Request\Queries\GetOrganizationRequestsCount;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;

class GetOrganizationRequestsCount implements IGetOrganizationRequestsCount
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $org_id): int
    {
        return $this->repository->getOrganizationRequestsCount($org_id);
    }
}
