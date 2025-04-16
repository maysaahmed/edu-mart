<?php

namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization;


interface IAssignAssessmentToOrganization
{
    public function execute(AssignAssessmentToOrganizationModel $model): bool;
}
