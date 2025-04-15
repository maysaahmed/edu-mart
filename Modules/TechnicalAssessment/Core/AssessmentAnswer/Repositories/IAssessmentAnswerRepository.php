<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories;

use App\Core\Repository\IRepository;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer\PostAssessmentAnswerModel;

interface IAssessmentAnswerRepository extends IRepository
{
    public function postAssessmentAnswers(PostAssessmentAnswerModel $model): bool;
}
