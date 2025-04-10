<?php

namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization;
use Spatie\LaravelData\Data;

class UnassignAssessmentFromOrganizationModel extends Data
{
    public function __construct(
        public int $organization_id,
        public int $assessment_id,

    ) {
    }
}
