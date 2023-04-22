<?php
namespace Modules\Administration\Core\Permission\Queries\GetPermissions;

use Modules\Administration\Core\Permission\Repositories\IPermissionRepository;
use Illuminate\Support\Collection;
use Modules\Administration\Core\Role\Repositories\IRoleRepository;

class GetPermissions implements IGetPermissions
{
    private IPermissionRepository $repository;
    private IRoleRepository $roleRepository;

    public function __construct(IPermissionRepository $repository, IRoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;

    }

    public function execute(?int $id = null): Collection
    {
        if($id)
        {
            $item =$this->roleRepository->getRoleById($id);

            if(!$item){
                throw new \Exception('Role cannot be found!');
            }
            return $this->repository->getPermissions($id);
        }

        return $this->repository->getPermissions();
    }
}
