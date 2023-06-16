<?php
namespace Modules\Users\Core\Manager\Commands\DeleteManager;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;

class DeleteManager implements IDeleteManager
{
    public function __construct(
        private IManagerRepository $repository,
    )
    {
    }

    public function execute($id, $deletedBy): bool
    {
        $item = $this->repository->getManagerByID($id);

        if(!$item){
            throw new \Exception('Manager cannot be found!');
        }

        $deleteItem = $this->repository->deleteManager($id, $deletedBy);

        if (!$deleteItem){
            throw new \Exception('Manager failed to remove!');
        }

        return true;
    }
}
