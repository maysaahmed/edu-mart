<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories;

use App\Core\Repository\IRepository;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion\CreateAssessmentQuestionModel;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

interface IAssessmentQuestionRepository extends IRepository
{
    public function createAssessmentQuestion(CreateAssessmentQuestionModel $model): AssessmentQuestion;

}
