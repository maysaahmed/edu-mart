<?php

namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer;
use Spatie\LaravelData\Data;

class PostAssessmentAnswerModel extends Data
{
    public function __construct(
        public int $assessment_id,
        public array $answers,
        public ?string $started_at = null,
        public ?string $submitted_at = null,

    ) {
    }
}
