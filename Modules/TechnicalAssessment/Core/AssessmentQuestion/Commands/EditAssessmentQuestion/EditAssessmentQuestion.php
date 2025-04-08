<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion;

use Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

class EditAssessmentQuestion implements IEditAssessmentQuestion
{
    private IAssessmentQuestionRepository $repository;

    public function __construct(IAssessmentQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditAssessmentQuestionModel $model): AssessmentQuestion
    {
        $item =$this->repository->getAssessmentQuestionById($model->id);

        if(!$item){
            throw new \Exception('Question cannot be found!');
        }

        $updatedItem = $this->repository->editAssessmentQuestion($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Question failed to update!');
    }
}
