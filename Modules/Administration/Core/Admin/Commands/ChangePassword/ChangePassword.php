<?php
namespace Modules\Administration\Core\Admin\Commands\ChangePassword;

use Illuminate\Support\Facades\Hash;
use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Modules\Administration\Domain\Entities\Admin\Admin;

class ChangePassword implements IChangePassword
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(ChangePasswordModel $model): Admin
    {
        $_profileId = $model->profileId;

        $item =$this->repository->getAdminById($_profileId);

        if(!$item){
            throw new \Exception('Profile cannot be found!');
        }

        if(!Hash::check($model->oldPassword, $item->password)) {
            throw new \Exception('Old password is not correct!');
        }

        $updatedItem = $this->repository->ChangePassword($_profileId, $model->newPassword);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Profile Password failed to update!');
    }
}
