<?php

namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier;

use Modules\TechnicalAssessment\Domain\Entities\AssessmentTier;

interface IEditAssessmentTier
{
    public function execute(EditAssessmentTierModel $model): AssessmentTier;
}
