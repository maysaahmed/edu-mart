<?php

namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion;
use Spatie\LaravelData\Data;

class EditAssessmentQuestionModel extends Data
{

    public function __construct(
        public int $id,
        public string $question,
        public string $question_type,
        public int $assessment_id,
        public array $answers ,

    ) {
    }

}
