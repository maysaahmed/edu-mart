<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Queries\GetAssessmentQuestion;

use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

interface IGetAssessmentQuestion
{
    public function execute(int $id): AssessmentQuestion|null;
}
