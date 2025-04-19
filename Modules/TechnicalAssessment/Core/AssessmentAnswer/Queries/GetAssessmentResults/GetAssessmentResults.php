<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetAssessmentResults;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;

class GetAssessmentResults implements IGetAssessmentResults
{
    private IAssessmentAnswerRepository $repository;

    public function __construct(IAssessmentAnswerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($assessment_id): Collection
    {
        return $this->repository->getAssessmentResults($assessment_id);
    }
}
