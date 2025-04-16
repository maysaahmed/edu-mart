<?php

namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion;

use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

interface IEditAssessmentQuestion
{
    public function execute(EditAssessmentQuestionModel $model): AssessmentQuestion;
}
