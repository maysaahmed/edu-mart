<?php
namespace Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetOrganizationRequestsPagination
{
    public function execute(GetOrganizationRequestsPaginationModel $model): LengthAwarePaginator;
}
