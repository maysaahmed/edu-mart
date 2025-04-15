<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;
use Spatie\LaravelData\Data;

class EditAssessmentModel extends Data
{

    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public string $desc,
        public string $assessment_type,
        public ?int $mcq_points,
        public ?int $tf_points,
        public ?int $sb_points,

    ) {
    }

}
