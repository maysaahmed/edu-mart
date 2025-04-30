<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessmentRecommendedCourses;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;

class GetAssessmentRecommendedCourses implements IGetAssessmentRecommendedCourses
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $assessment_id): Collection
    {
        $exist = $this->repository->getAssessmentById($assessment_id);
        if(!$exist)
            throw new \Exception('The assessment is not found.');

        $tookAssessment = $this->repository->checkUserTookAssessment($assessment_id);
        if(!$tookAssessment)
            throw new \Exception('You didn\'t take this assessment yet.');

        return $this->repository->getUserRecommendedCourses($assessment_id);
    }
}
