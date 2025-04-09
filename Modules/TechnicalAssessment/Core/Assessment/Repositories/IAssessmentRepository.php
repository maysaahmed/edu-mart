<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Support\Collection;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment\CreateAssessmentModel;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment\EditAssessmentModel;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

interface IAssessmentRepository extends IRepository
{
    public function getAssessmentById($id): Assessment|null;
   public function createAssessment(CreateAssessmentModel $model): Assessment;
    public function editAssessment(EditAssessmentModel $model): Assessment|null;
    public function deleteAssessment(int $id): bool;
}
