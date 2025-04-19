<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentAnswer;

use App\Infrastructure\Repository\Repository;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer\PostAssessmentAnswerModel;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;
use Modules\TechnicalAssessment\Domain\Entities\UserAssessmentResult;


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
            $assessment = Assessment::find($question->assessment_id);

            //correct answer
            $correctAnswerId = $question->answers()->where('is_correct', true)->value('id');

            $isCorrect = $answer['answer_id'] == $correctAnswerId;

            //points
            $typeToColumn = [
                'mcq' => 'mcq_points',
                't/f' => 'tf_points',
                'sb' => 'sb_points',
            ];

            $points = $assessment->{$typeToColumn[$question->question_type] ?? 'mcq_points'};

            return [
                'question_id' => $answer['question_id'],
                'answer_id' => $answer['answer_id'],
                'is_correct' => $isCorrect,
                'points' => $isCorrect ? $points : 0,
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
            ->distinct('user_id')
            ->get();
    }





}
