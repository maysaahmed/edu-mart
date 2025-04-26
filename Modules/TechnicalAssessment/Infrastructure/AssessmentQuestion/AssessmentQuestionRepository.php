<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentQuestion;

use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion\CreateAssessmentQuestionModel;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion\EditAssessmentQuestionModel;

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

    public function getAssessmentQuestionById($id): AssessmentQuestion|null
    {
        return AssessmentQuestion::find($id);
    }

    public function createAssessmentQuestion(CreateAssessmentQuestionModel $model): AssessmentQuestion
    {
        $ques= new AssessmentQuestion();
        $ques->ques = $model->question;
        $ques->question_type = $model->question_type;
        $ques->assessment_id = $model->assessment_id;
        $ques->weight = $model->weight;
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

    public function editAssessmentQuestion(EditAssessmentQuestionModel $model): AssessmentQuestion|null
    {
        $id = $model->id;
        $question = $this->getAssessmentQuestionById($id);

        if($question){

            $question->ques = $model->question;
            $question->question_type = $model->question_type;
            $question->assessment_id = $model->assessment_id;
            $question->weight = $model->weight;
            $save = $question->save();

            if ($save) {

                 $question->answers()->delete();
                foreach($model->answers as $item)
                {
                    AssessmentAnswer::create([
                        'question_id' => $question->id,
                        'answer_text' => $item['answer_text'],
                        'is_correct'    => $item['is_correct']
                    ]);
                }
                return $question;
            }
        }

        return null;
    }

    public function deleteAssessmentQuestion(int $id): bool
    {
        $item = $this->getAssessmentQuestionById($id);
        return  $item && $item->delete();
    }

}
