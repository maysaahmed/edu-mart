<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetAssessmentResults;

use Illuminate\Database\Eloquent\Collection;

interface IGetAssessmentResults
{
    public function execute(int $assessment_id): Collection;
}
