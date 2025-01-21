<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination;

use Illuminate\Support\Collection;

interface IGetApprovedRequestsPagination
{
    public function execute(GetApprovedRequestsPaginationModel $model): Collection;
}
