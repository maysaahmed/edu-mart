<?php

namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization;

interface IUnassignAssessmentFromOrganization
{
    public function execute(UnassignAssessmentFromOrganizationModel $model): bool;
}
