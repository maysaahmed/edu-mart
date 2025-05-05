<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessmentLimited;
use Spatie\LaravelData\Data;

class EditAssessmentLimitedModel extends Data
{

    public function __construct(
        public int $id,
        public int $retake_days,

    ) {
    }

}
