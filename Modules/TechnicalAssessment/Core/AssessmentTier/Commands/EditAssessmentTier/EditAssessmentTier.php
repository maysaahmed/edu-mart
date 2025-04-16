<?php
namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier;

use Modules\TechnicalAssessment\Core\AssessmentTier\Repositories\IAssessmentTierRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentTier;

class EditAssessmentTier implements IEditAssessmentTier
{
    private IAssessmentTierRepository $repository;

    public function __construct(IAssessmentTierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditAssessmentTierModel $model): AssessmentTier
    {
        $item =$this->repository->getAssessmentTierById($model->id);

        if(!$item){
            throw new \Exception('Tier cannot be found!');
        }

        $updatedItem = $this->repository->editAssessmentTier($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Tier failed to update!');
    }
}
