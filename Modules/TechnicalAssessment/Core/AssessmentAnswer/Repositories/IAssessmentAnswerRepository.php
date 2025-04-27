<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer\PostAssessmentAnswerModel;


interface IAssessmentAnswerRepository extends IRepository
{
    public function postAssessmentAnswers(PostAssessmentAnswerModel $model): bool;
    public function getAssessmentResults(int $assessment_id): Collection;
    public function getOrganizationReports(int $org_id): Collection;
}
