<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;
use Spatie\LaravelData\Data;

class EditAssessmentModel extends Data
{

    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public string $assessment_type,
        public int $retake_days,
        public ?string $desc = '',

    ) {
    }

}
