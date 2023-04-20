<?php
namespace Modules\Administration\Core\Admin\Commands\UpdateAdminStatus;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Modules\Administration\Domain\Entities\Admin\Admin;

class UpdateAdminStatus implements IUpdateAdminStatus
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(UpdateAdminStatusModel $model): Admin
    {
        $_id = $model->id;

        if($_id == $model->updatedBy){
            throw new \Exception('Admin cannot update himself!');
        }

        $item =$this->repository->getAdminById($_id);

        if(!$item){
            throw new \Exception('Admin cannot be found!');
        }

        $updatedItem = $this->repository->updateAdminStatus($_id, $model->status, $model->updatedBy);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Admin failed to update!');
    }
}
