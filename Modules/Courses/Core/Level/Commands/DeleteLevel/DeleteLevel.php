<?php
namespace Modules\Courses\Core\Level\Commands\DeleteLevel;

use Modules\Courses\Core\Level\Repositories\ILevelRepository;


class DeleteLevel implements IDeleteLevel
{
    private ILevelRepository $repository;

    public function __construct(ILevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getLevelById($id);

        if(!$item){
            throw new \Exception('Level cannot be found!');
        }

        $deleteItem = $this->repository->deleteLevel($id);

        if (!$deleteItem){
            throw new \Exception('Level failed to remove!');
        }

        return true;
    }
}
