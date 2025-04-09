<?php
namespace Modules\TechnicalAssessment\Infrastructure\Assessment;

use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment\CreateAssessmentModel;

use App\Infrastructure\Repository\Repository;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment\EditAssessmentModel;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

class AssessmentRepository extends Repository implements IAssessmentRepository
{
    protected function model(): string
    {
        return Assessment::class;
    }

    public function getAssessmentById($id): Assessment|null
    {
        return Assessment::find($id);
    }

    public function createAssessment(CreateAssessmentModel $model): Assessment
    {
        $assessment= new Assessment();
        $assessment->name = $model->name;
        $assessment->code = $model->code;
        $assessment->assessment_type = $model->assessment_type;
        $assessment->desc = $model->desc;
        $assessment->save();

        return $assessment;
    }

    public function editAssessment(EditAssessmentModel $model): Assessment|null
    {
        $id = $model->id;
        $assessment = $this->getAssessmentById($id);

        if($assessment){

            $assessment->name = $model->name;
            $assessment->code = $model->code;
            $assessment->assessment_type = $model->assessment_type;
            $assessment->desc = $model->desc;
            $save = $assessment->save();

            if ($save) {
                return $assessment;
            }
        }

        return null;
    }

    public function deleteAssessment(int $id): bool
    {
        $item = $this->getAssessmentById($id);
        return  $item && $item->delete();
    }


}
