<?php

namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\DeleteAssessmentQuestion;

interface IDeleteAssessmentQuestion
{
    public function execute(int $id): bool;
}
