<?php

namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\EditAssessmentOrganization;

interface IEditAssessmentOrganization
{
    public function execute(EditAssessmentOrganizationModel $model): bool;
}
