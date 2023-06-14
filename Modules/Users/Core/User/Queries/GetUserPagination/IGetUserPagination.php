<?php
namespace Modules\Users\Core\User\Queries\GetUserPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetUserPagination
{
    public function execute(GetUserPaginationModel $model): LengthAwarePaginator;
}
