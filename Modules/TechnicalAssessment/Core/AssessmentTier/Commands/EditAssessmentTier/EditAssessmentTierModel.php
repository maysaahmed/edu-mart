<?php

namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier;
use Spatie\LaravelData\Data;

class EditAssessmentTierModel extends Data
{

    public function __construct(
        public int $id,
        public string $evaluation,
        public int $from,
        public int $to,
        public int $assessment_id,
        public string $desc,
        public ?array $courses ,

    ) {
    }

}
