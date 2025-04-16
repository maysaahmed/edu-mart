<?php

namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion;

use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

interface ICreateAssessmentQuestion
{
    public function execute(CreateAssessmentQuestionModel $model): AssessmentQuestion;
}
