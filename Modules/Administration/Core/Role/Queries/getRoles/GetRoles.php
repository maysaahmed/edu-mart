<?php
namespace Modules\Administration\Core\Role\Queries\GetRoles;

use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use Illuminate\Support\Collection;

class GetRoles implements IGetRoles
{
    private IRoleRepository $repository;

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;

    }

    public function execute(?int $id = null): Collection
    {
        return $this->repository->getRoles();
    }
}
