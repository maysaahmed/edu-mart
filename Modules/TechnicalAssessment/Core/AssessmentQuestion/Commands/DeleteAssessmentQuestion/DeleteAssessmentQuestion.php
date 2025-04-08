<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\DeleteAssessmentQuestion;

use Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository;


class DeleteAssessmentQuestion implements IDeleteAssessmentQuestion
{
    private IAssessmentQuestionRepository $repository;

    public function __construct(IAssessmentQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getAssessmentQuestionById($id);

        if(!$item){
            throw new \Exception('Question cannot be found!');
        }

        $deleteItem = $this->repository->deleteAssessmentQuestion($id);

        if (!$deleteItem){
            throw new \Exception('Question failed to remove!');
        }

        return true;
    }
}
