<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Queries\GetQuestionsByAssessmentIDAndType;

use Illuminate\Database\Eloquent\Collection;

interface IGetQuestionsByAssessmentIDAndType
{
    public function execute(GetQuestionsByAssessmentIDAndTypeModel $model): Collection|null;
}
