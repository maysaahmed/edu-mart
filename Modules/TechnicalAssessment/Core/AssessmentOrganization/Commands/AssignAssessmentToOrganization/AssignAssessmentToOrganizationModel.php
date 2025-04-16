<?php

namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization;
use Spatie\LaravelData\Data;

class AssignAssessmentToOrganizationModel extends Data
{
    public function __construct(
        public int $organization_id,
        public int $assessment_id,
        public int $limit_users ,

    ) {
    }
}
