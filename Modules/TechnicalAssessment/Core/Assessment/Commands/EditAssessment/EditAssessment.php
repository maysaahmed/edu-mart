<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

class EditAssessment implements IEditAssessment
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditAssessmentModel $model): Assessment
    {
        $item =$this->repository->getAssessmentById($model->id);

        if(!$item){
            throw new \Exception('Assessment cannot be found!');
        }

        $updatedItem = $this->repository->editAssessment($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Assessment failed to update!');
    }
}
