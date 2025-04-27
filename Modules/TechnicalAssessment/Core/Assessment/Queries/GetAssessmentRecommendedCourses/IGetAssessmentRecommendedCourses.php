<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessmentRecommendedCourses;

use Illuminate\Database\Eloquent\Collection;

interface IGetAssessmentRecommendedCourses
{
    public function execute(int $assessment_id): Collection;
}
