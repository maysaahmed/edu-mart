<?php
namespace Modules\Assessment\Infrastructure\Question;

use App\Filters\FiltersJsonField;
use \Modules\Assessment\Core\Question\Queries\GetQuestionPagination\GetQuestionPaginationModel;
use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Assessment\Domain\Entities\Question;
class QuestionRepository extends Repository implements IQuestionRepository
{
    protected function model(): string
    {
        return Question::class;
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



}
