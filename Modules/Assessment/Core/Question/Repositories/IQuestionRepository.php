<?php
namespace Modules\Assessment\Core\Question\Repositories;

use App\Core\Repository\IRepository;
use Modules\Assessment\Core\Question\Queries\GetQuestionPagination\GetQuestionPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface IQuestionRepository extends IRepository
{

    public function getQuestionsPagination(GetQuestionPaginationModel $model): LengthAwarePaginator;

}
