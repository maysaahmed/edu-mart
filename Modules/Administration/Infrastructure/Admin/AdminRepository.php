<?php
namespace Modules\Administration\Infrastructure\Admin;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Administration\Domain\Entities\Admin\Admin;

use App\Enums\EnumUserTypes;

class AdminRepository extends Repository implements IAdminRepository
{

    protected function model(): string
    {
        return Admin::class;
    }

    public function getAdminByEmail(string $email): Admin|null
    {
        return Admin::Where('email', $email)->where('type', EnumUserTypes::Admin)->first();
    }

    public function getAdminByID($id): Admin|null
    {
        return Admin::find($id);
    }

    public function getAdmins(): \Illuminate\Support\Collection
    {
        return  Admin::where('type', EnumUserTypes::Admin)
            ->latest()
            ->get();
    }

    public function createAdmin(string $name, string $email, string $password, int $type, int $roleId, int $createdBy, int $isActive): Admin
    {
        $item = new Admin();
        $item->name = $name;
        $item->email = $email;
        $item->password = bcrypt($password);
        $item->type = $type;
        $item->created_by = $createdBy;
        $item->is_active = $isActive;
        $item->check_email_status = 1;
        $item->save();

        $item->syncRoles([$roleId]);

        return $item;
    }

    public function editAdmin(int $id, string $name, string $email, ?string $password, int $roleId, int $status, int $updatedBy): Admin|null
    {
        $item = $this->getAdminByID($id);

        if($item){

            $item->name = $name;
            $item->email = $email;

            if(filled($password)){
                $item->password = bcrypt($password);
            }

            $item->is_active = $status;
            $item->updated_by = $updatedBy;
            $save = $item->save();

            if ($save) {
                $item->syncRoles([$roleId]);

                return $item;
            }
        }

        return null;
    }

    public function deleteAdmin(int $id,  int $deletedBy): bool
    {
        $item = $this->getAdminByID($id);
        $item->deleted_at = now();
        $item->deleted_by = $deletedBy;

        return  $item && $item->save();
    }

    public function updateAdminStatus(int $id, int $isActive, int $updatedBy): Admin|null
    {
        $item = $this->getAdminByID($id);

        if($item){
            $item->is_active = $isActive;
            $item->updated_by = $updatedBy;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function editProfile(int $profileId, string $name, string $email): Admin|null
    {
        $item = $this->getAdminByID($profileId);

        if($item){

            $item->name = $name;
            $item->email = $email;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function ChangePassword(int $profileId, string $password): Admin|null
    {
        $item = $this->getAdminByID($profileId);

        if($item){

            $item->password = bcrypt($password);
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }
}
