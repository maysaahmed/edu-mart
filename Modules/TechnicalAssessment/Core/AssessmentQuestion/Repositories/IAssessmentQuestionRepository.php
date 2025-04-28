<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion\CreateAssessmentQuestionModel;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion\EditAssessmentQuestionModel;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Queries\GetQuestionsByAssessmentIDAndType\GetQuestionsByAssessmentIDAndTypeModel;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;

interface IAssessmentQuestionRepository extends IRepository
{
    public function createAssessmentQuestion(CreateAssessmentQuestionModel $model): AssessmentQuestion;
    public function getAssessmentQuestionById($id): AssessmentQuestion|null;
    public function getAssessmentQuestionsByType(GetQuestionsByAssessmentIDAndTypeModel $model): Collection|null;
    public function editAssessmentQuestion(EditAssessmentQuestionModel $model): AssessmentQuestion|null;
    public function deleteAssessmentQuestion(int $id): bool;
}
