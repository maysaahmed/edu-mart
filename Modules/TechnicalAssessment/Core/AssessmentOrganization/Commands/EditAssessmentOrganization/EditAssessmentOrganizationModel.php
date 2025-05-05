<?php

namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\EditAssessmentOrganization;
use Spatie\LaravelData\Data;

class EditAssessmentOrganizationModel extends Data
{
    public function __construct(
        public int $id,
        public int $limit_users,

    ) {
    }
}
