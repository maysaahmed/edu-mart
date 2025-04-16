<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode;
use Spatie\LaravelData\Data;

class CheckAssessmentCodeModel extends Data
{
    public function __construct(
        public int $assessment_id,
        public string $code,

    ) {
    }
}
