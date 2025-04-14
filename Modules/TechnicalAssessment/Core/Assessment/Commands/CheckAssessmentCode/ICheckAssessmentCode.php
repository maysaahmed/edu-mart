<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode;

use Modules\TechnicalAssessment\Domain\Entities\Assessment;

interface ICheckAssessmentCode
{
    public function execute(CheckAssessmentCodeModel $model): Assessment;
}
