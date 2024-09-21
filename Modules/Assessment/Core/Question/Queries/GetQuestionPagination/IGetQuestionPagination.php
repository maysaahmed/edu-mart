<?php
namespace Modules\Assessment\Core\Question\Queries\GetQuestionPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetQuestionPagination
{
    public function execute(GetQuestionPaginationModel $model): LengthAwarePaginator;
}
