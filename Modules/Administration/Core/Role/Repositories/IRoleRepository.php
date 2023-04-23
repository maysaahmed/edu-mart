<?php
namespace Modules\Administration\Core\Role\Repositories;

use App\Core\Repository\IRepository;

use Illuminate\Support\Collection;
use Modules\Administration\Core\Role\Commands\EditRole\EditRoleModel;
use Spatie\Permission\Models\Role;

interface IRoleRepository extends IRepository
{

    public function getRoleByName(string $roleName): Role|null;
    public function getRoleById(int $roleId): Role|null;

    public function getRoles(): Collection;
    public function createRole(string $name): Role;
    public function editRole(EditRoleModel $model): Role|null;


}
