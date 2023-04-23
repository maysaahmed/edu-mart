<?php
namespace Modules\Courses\Core\Provider\Queries\GetProviderPagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IGetProviderPagination
{
    public function execute(GetProviderPaginationModel $model): LengthAwarePaginator;
}
