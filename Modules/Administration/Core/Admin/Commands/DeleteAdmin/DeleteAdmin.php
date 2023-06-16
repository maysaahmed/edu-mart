<?php
namespace Modules\Administration\Core\Admin\Commands\DeleteAdmin;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;

class DeleteAdmin implements IDeleteAdmin
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(DeleteAdminModel $model): bool
    {
        $_id = $model->id;

        if($_id == $model->deletedBy){
            throw new \Exception('Admin cannot delete himself!');
        }

        $item =$this->repository->getAdminByID($_id);

        if(!$item){
            throw new \Exception('Admin cannot be found!');
        }

        $deleteItem = $this->repository->deleteAdmin($_id, $model->deletedBy);

        if (!$deleteItem){
            throw new \Exception('Admin failed to remove!');
        }

        return true;
    }
}
