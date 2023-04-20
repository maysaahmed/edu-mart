<?php
namespace Modules\Administration\Core\Role\Repositories;

use App\Core\Repository\IRepository;
use Spatie\Permission\Models\Role;

interface IRoleRepository extends IRepository
{
    public function getRoleByName(string $roleName): Role|null;
    public function getRoleById(int $roleId): Role|null;
}
