<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessmentLimited;

use Modules\TechnicalAssessment\Domain\Entities\Assessment;

interface IEditAssessmentLimited
{
    public function execute(EditAssessmentLimitedModel $model): Assessment;
}
