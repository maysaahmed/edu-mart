<?php
namespace Modules\Administration\Core\Admin\Commands\AdminAuth;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Illuminate\Support\Facades\Hash;

class AdminAuth implements IAdminAuth
{
    private IAdminRepository $repository;

    public function __construct(IAdminRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AdminAuthModel $model): array
    {
        $admin = $this->repository->getAdminByEmail($model->email);

        if ($admin) {
            if (Hash::check($model->password, $admin->password)) {
                $token = $admin->createToken('authToken', ['guard-admin-api'])->plainTextToken;
                $data = ['name' => $admin->name,'token' => $token, 'role' => 'admin'];

                return $data;
            }
        }

        //todo: through not found exception and handle it.
        //'The provided credentials do not match our records.!', Response::HTTP_UNAUTHORIZED)
        throw new \Exception('The provided credentials do not match our records.!');
    }
}
