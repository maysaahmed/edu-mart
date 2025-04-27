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
        return $this->repository->getUserRecommendedCourses($assessment_id);
    }
}
