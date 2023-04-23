<?php
namespace Modules\Administration\Core\Admin\Commands\EditAdmin;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use Modules\Administration\Domain\Entities\Admin\Admin;

class EditAdmin implements IEditAdmin
{
    public function __construct(
        private IAdminRepository $repository,
        private IRoleRepository $roleRepository
    )
    {
    }

    public function execute(EditAdminModel $model): Admin
    {
        $_id = $model->id;

        if($_id == $model->updatedBy){
            throw new \Exception('Admin cannot update himself!');
        }

        $item =$this->repository->getAdminById($_id);

        if(!$item){
            throw new \Exception('Admin cannot be found!');
        }

        $role = $this->roleRepository->getRoleById($model->roleId);

        if($role == null){
            throw new \Exception('Role cannot be found!');
        }

        $updatedItem = $this->repository->editAdmin($_id, $model->name, $model->email, $model->password, $model->roleId, $model->isActive, $model->updatedBy);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Admin failed to update!');
    }
}
