<?php
namespace Modules\Administration\Core\Admin\Queries\GetAdminPagination;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetAdminPagination implements IGetAdminPagination
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(GetAdminPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getAdminsPagination($model->page, $model->name, $model->email);
    }
}
