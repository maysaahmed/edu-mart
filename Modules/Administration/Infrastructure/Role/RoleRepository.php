<?php
namespace Modules\Administration\Infrastructure\Role;

//use Modules\Administration\Core\Role\Queries\GetRolePagination\GetRolePaginationModel;
use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleRepository extends Repository implements IRoleRepository
{
    protected function model(): string
    {
        return Role::class;
    }

    public function getRoleById(int $id): Role|null
    {
        return $Role = Role::find($id);
    }


    public function createRole(string $name): Role
    {
        $Role = new Role();
        $Role->name = $name;
        $Role->save();

        return $Role;
    }
}
