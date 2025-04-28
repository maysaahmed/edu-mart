<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Queries\GetAssessmentQuestion;

use Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

class GetAssessmentQuestion implements IGetAssessmentQuestion
{
    private IAssessmentQuestionRepository $repository;

    public function __construct(IAssessmentQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): AssessmentQuestion|null
    {
        $item =$this->repository->getAssessmentQuestionById($id);

        if(!$item){
            throw new \Exception('Question cannot be found!');
        }
        return $item;
    }
}
