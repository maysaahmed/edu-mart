<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;

use Modules\TechnicalAssessment\Domain\Entities\Assessment;

interface ICreateAssessment
{
    public function execute(CreateAssessmentModel $model): Assessment;
}
