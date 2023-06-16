<?php
namespace Modules\Users\Core\Manager\Queries\GetOrganizationManagers;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use Illuminate\Database\Eloquent\Collection;

class GetOrganizationManagers implements IGetOrganizationManagers
{
    private IManagerRepository $repository;

    public function __construct(IManagerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $org_id): Collection
    {
        return $this->repository->getOrganizationManagers($org_id);
    }
}
