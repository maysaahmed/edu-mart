<?php
namespace Modules\Administration\Infrastructure\Permission;

use Modules\Administration\Core\Permission\Queries\GetPermissionPagination\GetPermissionPaginationModel;
use Modules\Administration\Core\Permission\Repositories\IPermissionRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository implements IPermissionRepository
{
    protected function model(): string
    {
        return Permission::class;
    }

    public function getPermissions(?int $role_id = null): Collection|null
    {
        if ($role_id) {
            $this->addCriteria(new RoleIdCriteria($role_id));
        }

        return $this->all();
    }
}
