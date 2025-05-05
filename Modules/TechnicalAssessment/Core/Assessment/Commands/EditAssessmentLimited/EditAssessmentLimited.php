<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessmentLimited;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

class EditAssessmentLimited implements IEditAssessmentLimited
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditAssessmentLimitedModel $model): Assessment
    {
        $item =$this->repository->getAssessmentById($model->id);

        if(!$item){
            throw new \Exception('Assessment cannot be found!');
        }

        $updatedItem = $this->repository->editAssessmentLimited($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Assessment failed to update!');
    }
}
