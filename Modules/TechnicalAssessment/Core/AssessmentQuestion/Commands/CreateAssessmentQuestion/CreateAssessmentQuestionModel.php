<?php

namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion;
use Spatie\LaravelData\Data;

class CreateAssessmentQuestionModel extends Data
{
    public function __construct(
        public string $question,
        public string $question_type,
        public int $assessment_id,
        public array $answers ,

    ) {
    }
}
