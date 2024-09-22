<?php
namespace Modules\Assessment\Infrastructure\Question;

use App\Filters\FiltersJsonField;
use \Modules\Assessment\Core\Question\Queries\GetQuestionPagination\GetQuestionPaginationModel;
use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Course;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Assessment\Domain\Entities\Question;
use Modules\Assessment\Core\Question\Commands\EditQuestion\EditQuestionModel;

class QuestionRepository extends Repository implements IQuestionRepository
{
    protected function model(): string
    {
        return Question::class;
    }

    public function getQuestionById($id): Question|null
    {
        return Question::find($id);
    }

    public function getQuestionsPagination(GetQuestionPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Question::class)
            ->allowedFilters([
                AllowedFilter::custom('ques', new FiltersJsonField)
            ])
            ->latest()
            ->paginate();
    }

    public function editQuestion(EditQuestionModel $model): Question|null
    {
        $id = $model->id;
        $question = $this->getQuestionById($id);

        if($question){

            $question->ques = [
                'en' => $model->ques_en,
                'ar' => $model->ques_ar
            ];
            $question->order = $model->order;
            $question->factor_id = $model->factor_id;
            $save = $question->save();

            if ($save) {
                return $question;
            }
        }

        return null;
    }



}
