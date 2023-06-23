<?php
namespace Modules\Organizations\Core\Organization\Queries\GetOrganizationList;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Illuminate\Database\Eloquent\Collection;

class GetOrganizationList implements IGetOrganizationList
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getOrganizationList();
    }
}
