<?php
namespace Modules\Assessment\Core\Factor\Commands\EditFormula;

use Modules\Assessment\Core\Factor\Repositories\IFactorRepository;
use Modules\Assessment\Domain\Entities\Factor;

class EditFormula implements IEditFormula
{
    private IFactorRepository $repository;

    public function __construct(IFactorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditFormulaModel $model): bool
    {
        $item =$this->repository->getFactorById($model->id);

        if(!$item){
            throw new \Exception('Formula cannot be found!');
        }

        $updatedItem = $this->repository->editFormula($model);
        if ($updatedItem){
            return true;
        }

        throw new \Exception('Formula failed to update!');
    }
}
