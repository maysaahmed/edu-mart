<?php
namespace Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetOrganizationPagination
{
    public function execute(GetOrganizationPaginationModel $model): LengthAwarePaginator;
}
