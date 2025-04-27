<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentTier;

use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier\CreateAssessmentTierModel;
use Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier\EditAssessmentTierModel;

use App\Infrastructure\Repository\Repository;

use Modules\TechnicalAssessment\Core\AssessmentTier\Repositories\IAssessmentTierRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentTier;

class AssessmentTierRepository extends Repository implements IAssessmentTierRepository
{
    protected function model(): string
    {
        return AssessmentTier::class;
    }

    public function getAssessmentTierById($id): AssessmentTier|null
    {
        return AssessmentTier::find($id);
    }

    public function createAssessmentTier(CreateAssessmentTierModel $model): AssessmentTier
    {
        $tier = new AssessmentTier();
        $tier->evaluation = $model->evaluation;
        $tier->from = $model->from;
        $tier->to = $model->to;
        $tier->desc = $model->desc;
        $tier->assessment_id = $model->assessment_id;
        $tier->save();
        if($model->courses)
            $tier->courses()->syncWithoutDetaching($model->courses);

        return $tier;
    }

    public function editAssessmentTier(EditAssessmentTierModel $model): AssessmentTier|null
    {
        $id = $model->id;
        $tier = $this->getAssessmentTierById($id);

        if($tier){
            $tier->evaluation = $model->evaluation;
            $tier->from = $model->from;
            $tier->to = $model->to;
            $tier->desc = $model->desc;
            $tier->assessment_id = $model->assessment_id;
            $save = $tier->save();

            if ($save) {
                $tier->courses()->detach();
                if($model->courses)
                    $tier->courses()->syncWithoutDetaching($model->courses);
                return $tier;
            }
        }

        return null;
    }

    public function deleteAssessmentTier(int $id): bool
    {
        $item = $this->getAssessmentTierById($id);
        return  $item && $item->delete();
    }

}
