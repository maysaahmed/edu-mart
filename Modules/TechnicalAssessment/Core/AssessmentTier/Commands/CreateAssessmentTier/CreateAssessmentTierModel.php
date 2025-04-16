<?php

namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier;
use Spatie\LaravelData\Data;

class CreateAssessmentTierModel extends Data
{
    public function __construct(
        public string $evaluation,
        public int $from,
        public int $to,
        public int $assessment_id,
        public string $desc,
        public array $courses ,

    ) {
    }
}
