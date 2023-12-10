<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetApprovedRequestsPagination
{
    public function execute(GetApprovedRequestsPaginationModel $model): LengthAwarePaginator;
}
