<?php
namespace Modules\Users\Core\Manager\Commands\EditManagerStatus;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use Modules\Users\Domain\Entities\Manager;

class EditManagerStatus implements IEditManagerStatus
{
    private IManagerRepository $repository;

    public function __construct(IManagerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditManagerStatusModel $model): Manager
    {
        $item =$this->repository->getManagerById($model->id);

        if(!$item){
            throw new \Exception('Manager cannot be found!');
        }

        $updatedItem = $this->repository->editManagerStatus($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Manager Status failed to update!');
    }
}
