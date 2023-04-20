<?php
namespace Modules\Administration\Infrastructure\Role;

use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use App\Infrastructure\Repository\Repository;
use Spatie\Permission\Models\Role;

class RoleRepository extends Repository implements IRoleRepository
{
    protected function model(): string
    {
        return Role::class;
    }

    public function getRoleByName(string $roleName): Role|null
    {
        try {
            return Role::findByName($roleName);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRoleById($roleId): Role|null
    {
        try {
            return Role::findById($roleId);
        } catch (\Exception $e) {
            return null;
        }
    }

}
