<?php
namespace Modules\TechnicalAssessment\Core\AssessmentTier\Repositories;

use App\Core\Repository\IRepository;
use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier\CreateAssessmentTierModel;
use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier\EditAssessmentTierModel;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentTier;

interface IAssessmentTierRepository extends IRepository
{
    public function createAssessmentTier(CreateAssessmentTierModel $model): AssessmentTier;
    public function getAssessmentTierById($id): AssessmentTier|null;
    public function editAssessmentTier(EditAssessmentTierModel $model): AssessmentTier|null;
    public function deleteAssessmentTier(int $id): bool;
}
