<?php
namespace Modules\Administration\Core\Admin\Queries\GetAdminPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetAdminPagination
{
    public function execute(GetAdminPaginationModel $model): LengthAwarePaginator;
}
