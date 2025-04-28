<?php

namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Queries\GetQuestionsByAssessmentIDAndType;
use Spatie\LaravelData\Data;

class GetQuestionsByAssessmentIDAndTypeModel extends Data
{

    public function __construct(
        public string $question_type,
        public int $assessment_id,

    ) {
    }

}
