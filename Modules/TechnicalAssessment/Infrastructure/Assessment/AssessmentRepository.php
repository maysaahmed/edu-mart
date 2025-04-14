<?php
namespace Modules\TechnicalAssessment\Infrastructure\Assessment;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode\CheckAssessmentCodeModel;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment\CreateAssessmentModel;

use App\Infrastructure\Repository\Repository;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment\EditAssessmentModel;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;
use Illuminate\Support\Str;

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

    public function getAssessments(): Collection
    {
        return  Assessment::latest()->get();
    }

    public function createAssessment(CreateAssessmentModel $model): Assessment
    {
        $assessment= new Assessment();
        $assessment->name = $model->name;
        $assessment->code = $model->code;
        $assessment->assessment_type = $model->assessment_type;
        $assessment->desc = $model->desc;
        $assessment->mcq_points = $model->mcq_points;
        $assessment->tf_points = $model->tf_points;
        $assessment->sb_points = $model->sb_points;
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
            $assessment->mcq_points = $model->mcq_points;
            $assessment->tf_points = $model->tf_points;
            $assessment->sb_points = $model->sb_points;
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

    public function checkAssessmentCode(CheckAssessmentCodeModel $model): bool
    {
        $assessment = Assessment::where(['id' => $model->assessment_id, 'code' => $model->code])->first();
        if($assessment)
            return true;
        return false;
    }

    public function checkUserEmail(int $assessment_id): bool
    {
        $email = auth()->user()->email;
        $domain = Str::after($email, '@');
        $assessment = $this->getAssessmentById($assessment_id);

        $hasDomain = $assessment->organizations()->where('domain', $domain)->exists();

        if($hasDomain)
            return true;
        return false;
    }
}
