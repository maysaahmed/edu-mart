<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion;

use Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

class CreateAssessmentQuestion implements ICreateAssessmentQuestion
{
    private IAssessmentQuestionRepository $repository;

    public function __construct(IAssessmentQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateAssessmentQuestionModel $model): AssessmentQuestion
    {
        return $this->repository->createAssessmentQuestion($model);
    }
}

