<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer;

use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;

class PostAssessmentAnswer implements IPostAssessmentAnswer
{
    private IAssessmentAnswerRepository $repository;

    public function __construct(IAssessmentAnswerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PostAssessmentAnswerModel $model): bool
    {
        return $this->repository->postAssessmentAnswers($model);
    }
}

