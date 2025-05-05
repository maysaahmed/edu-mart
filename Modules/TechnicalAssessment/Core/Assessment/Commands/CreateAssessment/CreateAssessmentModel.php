<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;

use Spatie\LaravelData\Data;

class CreateAssessmentModel extends Data
{
    public function __construct(
        public string $name,
        public string $code,
        public string $assessment_type,
        public int $retake_days,
        public ?string $desc = '',

    ) {
    }
}
