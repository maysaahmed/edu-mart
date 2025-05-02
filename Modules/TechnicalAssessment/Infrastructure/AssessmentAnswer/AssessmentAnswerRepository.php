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
use ZipArchive;



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

        if ($save)
        {
            $domain = getAuthUserDomain();
            $assessment = Assessment::find($model->assessment_id);
            $organization = $assessment->organizations()->where('domain', $domain)->first();
            $report = OrganizationAssessment::where('organization_id', $organization->id, $model->assessment_id)->first();
            $report->report = null;
            $report->save();
            return true;
        }

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

    protected function generateReport($org_id, $assessment_id): ?string
    {
        $organization = Organization::find($org_id);
        $assessment = Assessment::find($assessment_id);
        $totalWeight = AssessmentQuestion::where('assessment_id', $assessment_id)->sum('weight');

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

        if($results->isNotEmpty())
        {
            $report = $results->flatMap(function ($result) use ($totalWeight) {
                $tier = $result->assessment->tiers
                    ->firstWhere(fn($t) => $result->score >= $t->from && $result->score <= $t->to);

                $courses = $tier?->courses ?? collect();
                $userScore = $result->score ?? 0;

                $percentage = $totalWeight > 0
                    ? round(($userScore / $totalWeight) * 100, 2)
                    : 0;

                $base = [
                    'user'         => $result->user->name ?? '-',
                    'email'        => $result->user->email ?? '-',
                    'score'        => $userScore,
                    'percentage'   => $percentage.'%',
                    'submitted_at' => $result->submitted_at,
                    'tier'         => $tier?->evaluation ?? '-',
                    'feedback'     => strip_tags($tier?->desc ?? '-'),
                ];

                return $courses->isNotEmpty()
                    ? $courses->map(function ($course) use ($base) {
                        return array_merge($base, [
                            'recommended_courses' => $course?->title ?? '-',
                        ]);
                    })->values()
                    : collect([
                        array_merge($base, ['recommended_courses' => '-'])
                    ]);
            });

            $filename = str_replace(' ', '_', $organization->name).'-'.str_replace(' ', '_', $assessment->name).'-report.csv';


            // Store to storage
            Excel::store(new OrganizationAssessmentResultExport($report), 'reports/' . $filename, 'local', \Maatwebsite\Excel\Excel::CSV);


            return $filename;
        }else{
            return null;
        }

    }
    public function getOrganizationReports(int $org_id) : Collection
    {
        //get organization reports
        $reports = OrganizationAssessment::where('organization_id', $org_id)->get();

        foreach ($reports as $report) {

            $reportFile = 'reports/' . $report->report;

            if (!$report->report || !Storage::exists($reportFile)) {
                $generatedFile = $this->generateReport($org_id, $report->assessment_id);

                if($generatedFile)
                {
                    $report->report = $generatedFile;
                    $report->save();
                }

            }
        }
        return OrganizationAssessment::where('organization_id', $org_id)->whereNotNull('report')->get();
    }


    public function getOrganizationReportsZip(int $org_id) : string|bool
    {
        $organization = Organization::find($org_id);

        $reports = OrganizationAssessment::where('organization_id', $org_id)
            ->whereNotNull('report')
            ->get();

        $reportDir = storage_path('app/reports');
        if (!file_exists($reportDir)) {
            mkdir($reportDir, 0755, true);
        }

        $zip = new ZipArchive();
        $zipFileName = str_replace(' ', '_', $organization->name) . '_reports.zip';
        $zipPath = $reportDir . '/' . $zipFileName;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($reports as $report) {
                $filePath = storage_path("app/reports/{$report->report}");

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();

        } else {
            return false;
        }
        return $zipFileName;

    }




}
