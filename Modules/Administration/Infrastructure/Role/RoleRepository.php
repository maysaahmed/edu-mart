<?php
namespace Modules\Administration\Infrastructure\Role;

use Modules\Administration\Core\Role\Queries\getRoles\GetRoles;
use Illuminate\Support\Collection;
use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Administration\Core\Role\Commands\EditRole\EditRoleModel;
use Modules\Administration\Domain\Entities\Admin\Admin;
use Spatie\Permission\Models\Role;
use DB;

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

    public function createRole(string $name): Role
    {
        $Role = new Role();
        $Role->name = $name;
        $Role->save();

        return $Role;
    }

    public function getRoles(): Collection
    {
       return Role::all();
    }

    public function editRole(EditRoleModel $model): Role|null
    {
        $role = $this->getRoleById($model->id);
        if($role){

            if ($role->syncPermissions($model->permissions)) {
                //get all users with role name
//                $admins = Admin::role([$role->name])->select('id')->get()->pluck('id');
//                DB::table('personal_access_tokens')->whereIn('tokenable_id', $admins)->delete();
                return $role;
            }
        }

        return null;
    }
}
