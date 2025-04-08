<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentQuestion;

use Modules\Courses\Core\Course\Commands\EditCourse\EditCourseModel;
use Modules\Courses\Domain\Entities\Course;
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

//    public function editAssessmentQuestion(EditCourseModel $model): Course|null
//    {
//        $id = $model->id;
//        $course = $this->getCourseById($id);
//
//        if($course){
//
//            $course->title = $model->title;
//            $course->desc = $model->desc;
//            $course->duration = $model->duration;
//            $course->price = $model->price;
//            $course->level_id = $model->level_id;
//            $course->category_id = $model->category_id;
//            $course->provider_id = $model->provider_id;
//            $course->location = $model->location;
//            $save = $course->save();
//
//            if ($save) {
//
//                foreach($model->factors as $item)
//                {
//                    $course->courseFactors()->updateOrCreate(
//                        ['factor_id' => $item['factor_id']],
//                        ['result' => $item['result']]
//                    );
//
//                }
//                return $course;
//            }
//        }
//
//        return null;
//    }

    public function deleteAssessmentQuestion(int $id): bool
    {
        $item = $this->getAssessmentQuestionById($id);
        return  $item && $item->delete();
    }

}
