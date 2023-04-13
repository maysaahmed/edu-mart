<?php
namespace Modules\Administration\Core\Admin\Repositories;

use App\Core\Repository\IRepository;
use Modules\Administration\Core\Admin\Commands\CreateAdmin\CreateAdminModel;
use Modules\Administration\Core\Admin\Queries\GetAdminPagination\GetAdminPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Administration\Domain\Entities\Admin\Admin;

interface IAdminRepository extends IRepository
{
    public function getAdminByEmail(string $email): Admin;
    public function getAdminsPagination(GetAdminPaginationModel $model): LengthAwarePaginator;
    public function createAdmin(CreateAdminModel $model): Admin;
}
