<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentQuestion;

use Modules\Courses\Domain\Entities\CourseFactor;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion\CreateAssessmentQuestionModel;

use App\Infrastructure\Repository\Repository;

use Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentQuestion;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentAnswer;

class AssessmentQuestionRepository extends Repository implements IAssessmentQuestionRepository
{
    protected function model(): string
    {
        return AssessmentQuestion::class;
    }

    public function createAssessmentQuestion(CreateAssessmentQuestionModel $model): AssessmentQuestion
    {
        $ques= new AssessmentQuestion();
        $ques->ques = $model->question;
        $ques->question_type = $model->question_type;
        $ques->assessment_id = $model->assessment_id;
        $ques->save();

        foreach($model->answers as $item)
        {
            AssessmentAnswer::create([
                'question_id' => $ques->id,
                'answer_text' => $item['answer_text'],
                'is_correct'    => $item['is_correct']
            ]);
        }
        return $ques;
    }


}
