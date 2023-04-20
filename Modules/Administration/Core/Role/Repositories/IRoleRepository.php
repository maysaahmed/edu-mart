<?php
namespace Modules\Administration\Core\Role\Repositories;

use App\Core\Repository\IRepository;
//use Modules\Administration\Core\Role\Queries\GetRolePagination\GetRolePaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface IRoleRepository extends IRepository
{
    public function getRoleById(int $id): Role|null;
//    public function getRolesPagination(GetRolePaginationModel $model): LengthAwarePaginator;
    public function createRole(string $name): Role;
}
