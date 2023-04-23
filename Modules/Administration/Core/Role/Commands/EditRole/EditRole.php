<?php
namespace Modules\Administration\Core\Role\Commands\EditRole;

use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use Spatie\Permission\Models\Role;

class EditRole implements IEditRole
{
    private IRoleRepository $repository;

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditRoleModel $model): Role
    {
        $item =$this->repository->getRoleById($model->id);

        if(!$item){
            throw new \Exception('Role cannot be found!');
        }

        $updatedItem = $this->repository->editRole($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Role failed to update!');
    }
}
