<?php
namespace Modules\Administration\Core\Admin\Commands\CreateAdmin;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use Modules\Administration\Domain\Entities\Admin\Admin;

class CreateAdmin implements ICreateAdmin
{
    public function __construct(
        private IAdminRepository $repository,
        private IRoleRepository $roleRepository
    )
    {
    }

    public function execute(CreateAdminModel $model): Admin
    {
        $role = $this->roleRepository->getRoleById($model->roleId);
        if($role == null){
            throw new \Exception('Role cannot be found!');
        }

        return $this->repository->createAdmin($model->name, $model->email, $model->password, $model->type, $model->roleId, $model->createdBy);
    }
}
