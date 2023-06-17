<?php
namespace Modules\Users\Core\Manager\Queries\GetManagerPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetManagerPagination
{
    public function execute(GetManagerPaginationModel $model): LengthAwarePaginator;
}
