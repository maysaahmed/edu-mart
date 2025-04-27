<?php
namespace Modules\TechnicalAssessment\Infrastructure\Assessment;

use Illuminate\Database\Eloquent\Collection;

use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment\CreateAssessmentModel;

use App\Infrastructure\Repository\Repository;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment\EditAssessmentModel;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;
use Modules\TechnicalAssessment\Domain\Entities\UserAssessmentResult;

use Carbon\Carbon;

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

    public function checkAssessmentCode(int $assessment_id, string $code): bool
    {
        $assessment = Assessment::where(['id' => $assessment_id, 'code' => $code])->first();
        if($assessment)
            return true;
        return false;
    }

    public function checkUserEmail(int $assessment_id): bool
    {
        $domain = getAuthUserDomain();
        $assessment = $this->getAssessmentById($assessment_id);

        $hasDomain = $assessment->organizations()->where('domain', $domain)->exists();

        if($hasDomain)
            return true;
        return false;
    }

    public function canUserRetakeAssessment(int $assessment_id): int|bool
    {
        $userId = auth()->id();
        $days  = config('assessment.retake_days');

        $result = UserAssessmentResult::where('user_id', $userId)
            ->where('assessment_id', $assessment_id)
            ->orderByDesc('submitted_at')
            ->first();

        if (! $result || !$result->submitted_at) {
            return true;
        }

        $nextAllowedDate = Carbon::parse($result->submitted_at)
            ->addDays($days);

        if (now()->lt($nextAllowedDate)) {
            return now()->diffInDays($nextAllowedDate);
        }
        return true;

    }

    public function checkUserLimitOrganization(int $assessment_id): bool
    {
        $domain = getAuthUserDomain();
        $assessment = $this->getAssessmentById($assessment_id);

        $organization = $assessment->organizations()->where('domain', $domain)->first();


        // Count unique users who have started this assessment
        $results = UserAssessmentResult::where('assessment_id', $assessment_id)
            ->where('user_id', '!=', auth()->id())
            ->whereHas('user', function ($query) use ($domain) {
            $query->where('email', 'like', '%@' . $domain);
        })->distinct('user_id')->count();

        if($results < $organization->pivot->limit_users)
            return false;

        return true;
    }

    public function getUserAssessments() :Collection
    {
        $domain = getAuthUserDomain();
        return Assessment::whereHas('organizations', function ($query) use ($domain) {
            $query->where('domain', $domain);
        })->get();
    }

    public function getUserRecommendedCourses($assessment_id) : Collection
    {


    }
}
