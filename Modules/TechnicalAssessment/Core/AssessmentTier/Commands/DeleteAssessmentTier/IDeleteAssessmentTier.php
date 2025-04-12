<?php

namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\DeleteAssessmentTier;

interface IDeleteAssessmentTier
{
    public function execute(int $id): bool;
}
