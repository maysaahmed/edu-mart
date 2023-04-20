<?php
namespace Modules\Courses\Core\Level\Commands\EditLevel;

use Modules\Courses\Core\Level\Repositories\ILevelRepository;
use Modules\Courses\Domain\Entities\Level;

class EditLevel implements IEditLevel
{
    private ILevelRepository $repository;

    public function __construct(ILevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditLevelModel $model): Level
    {
        $item =$this->repository->getLevelById($model->id);

        if(!$item){
            throw new \Exception('Level cannot be found!');
        }

        $updatedItem = $this->repository->editLevel($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Level failed to update!');
    }
}
