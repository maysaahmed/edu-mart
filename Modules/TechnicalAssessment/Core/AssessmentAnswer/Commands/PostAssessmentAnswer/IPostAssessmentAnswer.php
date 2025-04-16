<?php

namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer;



interface IPostAssessmentAnswer
{
    public function execute(PostAssessmentAnswerModel $model): bool;
}
