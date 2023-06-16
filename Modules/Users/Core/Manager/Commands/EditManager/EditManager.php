<?php
namespace Modules\Users\Core\Manager\Commands\EditManager;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use Modules\Users\Domain\Entities\Manager;

class EditManager implements IEditManager
{
    public function __construct(
        private IManagerRepository $repository
    )
    {
    }

    public function execute(EditManagerModel $model): Manager
    {
        $_id = $model->id;
        $item = $this->repository->getManagerById($_id);

        if(!$item){
            throw new \Exception('Manager cannot be found!');
        }

        $updatedItem = $this->repository->editManager($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Manager failed to update!');
    }
}
