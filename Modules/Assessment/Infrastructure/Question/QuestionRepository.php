<?php
namespace Modules\Assessment\Infrastructure\Question;

use App\Filters\FiltersJsonField;
use \Modules\Assessment\Core\Question\Queries\GetQuestionPagination\GetQuestionPaginationModel;
use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Assessment\Domain\Entities\Question;
use Modules\Assessment\Core\Question\Commands\EditQuestion\EditQuestionModel;
use DB;

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
            ->orderBy('order', 'asc')
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
            $question->factor_id = $model->factor_id;
            $save = $question->save();

            if ($save) {
                return $question;
            }
        }

        return null;
    }

    public function reorderQuestions(Array $questions): bool|null
    {
        // Start a database transaction
        DB::beginTransaction();
        try {
            // Loop through each question and update its order
            foreach ($questions as $questionData) {
                Question::where('id', $questionData['id'])
                    ->update(['order' => $questionData['order']]);
            }

            // Commit the transaction
            DB::commit();

            return true;
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();

            return false;
        }

        return null;
    }
    public function getQuestions(): Collection
    {
        return Question::orderBy('order', 'ASC')->get();

    }



}
