<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentAnswer;

use App\Infrastructure\Repository\Repository;

use Illuminate\Database\Eloquent\Collection;
use Modules\Organizations\Domain\Entities\Organization\Organization;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer\PostAssessmentAnswerModel;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;
use Modules\TechnicalAssessment\Domain\Entities\OrganizationAssessment;
use Modules\TechnicalAssessment\Domain\Entities\UserAssessmentResult;

use Modules\TechnicalAssessment\Infrastructure\AssessmentAnswer\Exports\OrganizationAssessmentResultExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class AssessmentAnswerRepository extends Repository implements IAssessmentAnswerRepository
{
    protected function model(): string
    {
        return UserAssessmentResult::class;
    }
    public function getCalculatedScoreAttribute($answers)
    {
        return collect($answers)->sum(fn($answer) => $answer['points'] ?? 0);
    }

    public function updateAnswers($answers): array
    {
        return collect($answers)->map(function ($answer) {

            $question = AssessmentQuestion::find($answer['question_id']);

            //correct answer
            $correctAnswerId = $question->answers()->where('is_correct', true)->value('id');

            $isCorrect = $answer['answer_id'] == $correctAnswerId;

            return [
                'question_id' => $answer['question_id'],
                'answer_id' => $answer['answer_id'],
                'is_correct' => $isCorrect,
                'points' => $isCorrect ? $question->weight : 0,
            ];
        })->toArray();

    }

    public function postAssessmentAnswers(PostAssessmentAnswerModel $model): bool
    {
        // calculate score
        $answers = $this->updateAnswers($model->answers);
        $score = $this->getCalculatedScoreAttribute($answers);

        // Create result
        $result = new UserAssessmentResult();
        $result->user_id = auth()->id();
        $result->assessment_id = $model->assessment_id;
        $result->score = $score;
        $result->started_at = $model->started_at;
        $result->submitted_at = $model->submitted_at ?? now();
        $result->answers = json_encode($answers);
        $save = $result->save();

        if($save)
            return true;
        return false;
    }

    public function getAssessmentResults(int $assessment_id):Collection
    {
        return UserAssessmentResult::where('assessment_id', $assessment_id)
            ->whereNotNull('submitted_at')
            ->orderByDesc('submitted_at')
            ->get()
            ->unique('user_id')
            ->values();
    }

    protected function generateReport($org_id, $assessment_id): string
    {
        $organization = Organization::find($org_id);
        $assessment = Assessment::find($assessment_id);

        //generate report
        $results = UserAssessmentResult::whereHas('assessment.organizations', function ($q) use ($org_id) {
            $q->where('organizations.id', $org_id);
        })
            ->where('assessment_id', $assessment_id)
            ->whereNotNull('submitted_at')
            ->orderByDesc('submitted_at')
            ->with(['user', 'assessment', 'assessment.tiers'])
            ->get()
            ->unique('user_id')
            ->values();

        $report = $results->map(function ($result) {
            $tier = $result->assessment->tiers
                ->firstWhere(fn($t) => $result->score >= $t->from && $result->score <= $t->to);

            return [
                'user'        => $result->user->name,
                'email'       => $result->user->email,
                'score'       => $result->score,
                'submitted_at'=> $result->submitted_at,
                'tier'        => $tier?->evaluation ?? 'N/A',
            ];
        });

        $filename = str_replace(' ', '_', $organization->name).'-'.str_replace(' ', '_', $assessment->name).'-report.csv';


        // Store to storage
        Excel::store(new OrganizationAssessmentResultExport($report), 'reports/' . $filename, 'local', \Maatwebsite\Excel\Excel::CSV);


        return $filename;
    }
    public function getOrganizationReports(int $org_id) : Collection
    {
        //get organization reports
        $reports = OrganizationAssessment::where('organization_id', $org_id)->get();
        foreach ($reports as $report) {

            $reportFile = 'reports/' . $report->report;

            if (!$report->report || !Storage::exists($reportFile)) {
                $generatedFile = $this->generateReport($org_id, $report->assessment_id);
                $report->report = $generatedFile;
                $report->save();
            }
        }
        return $reports;
    }





}
