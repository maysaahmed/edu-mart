<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;

use Modules\TechnicalAssessment\Domain\Entities\Assessment;

interface IEditAssessment
{
    public function execute(EditAssessmentModel $model): Assessment;
}
