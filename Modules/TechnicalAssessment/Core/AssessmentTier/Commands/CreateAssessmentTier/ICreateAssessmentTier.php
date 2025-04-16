<?php

namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier;

use Modules\TechnicalAssessment\Domain\Entities\AssessmentTier;

interface ICreateAssessmentTier
{
    public function execute(CreateAssessmentTierModel $model): AssessmentTier;
}
