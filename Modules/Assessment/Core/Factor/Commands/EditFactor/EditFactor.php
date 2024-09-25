<?php
namespace Modules\Assessment\Core\Factor\Commands\EditFactor;

use Modules\Assessment\Core\Factor\Repositories\IFactorRepository;
use Modules\Assessment\Domain\Entities\Factor;

class EditFactor implements IEditFactor
{
    private IFactorRepository $repository;

    public function __construct(IFactorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditFactorModel $model): Factor
    {
        $item =$this->repository->getFactorById($model->id);

        if(!$item){
            throw new \Exception('Factor cannot be found!');
        }

        $updatedItem = $this->repository->editFactor($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Factor failed to update!');
    }
}
