<?php
namespace Modules\Administration\Core\Admin\Commands\AdminAuth;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Illuminate\Support\Facades\Hash;

class AdminAuth implements IAdminAuth
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(AdminAuthModel $model): array
    {
        $admin = $this->repository->getAdminByEmail($model->email);

        if ($admin) {
            if (Hash::check($model->password, $admin->password)) {

                if(!$admin->is_active)
                {
                    throw new \Exception('The user account is blocked!');
                }
                $permissions = $admin->getAllPermissions();
                $abilities = [];
                foreach($permissions as $p) {
                    $abilities[] = $p->name;
                }

                $token = $admin->createToken('admin-token',$abilities)->plainTextToken;
                $data = ['user' => $admin,'token' => $token];
                return $data;
            }
        }

        //todo: through not found exception and handle it.
        //'The provided credentials do not match our records.!', Response::HTTP_UNAUTHORIZED)
        throw new \Exception('The provided credentials do not match our records.!');
    }
}
