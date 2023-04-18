<?php
namespace Modules\Courses\Core\Category\Queries\GetCategoryPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetCategoryPagination
{
    public function execute(GetCategoryPaginationModel $model): LengthAwarePaginator;
}
