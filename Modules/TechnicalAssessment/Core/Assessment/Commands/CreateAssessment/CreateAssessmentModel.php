<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;
use Spatie\LaravelData\Data;

class CreateAssessmentModel extends Data
{
    public function __construct(
        public string $name,
        public string $code,
        public string $desc,
        public string $assessment_type,
        public ?int $mcq_points = null,
        public ?int $tf_points = null ,
        public ?int $sb_points = null,

    ) {
    }
}
