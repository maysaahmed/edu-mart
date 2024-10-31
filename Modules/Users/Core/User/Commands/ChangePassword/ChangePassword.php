<?php
namespace Modules\Users\Core\User\Commands\ChangePassword;

use Illuminate\Support\Facades\Hash;
use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\User;

class ChangePassword implements IChangePassword
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute(ChangePasswordModel $model): EndUser
    {
        $id = $model->id;

        $item =$this->repository->getUserById($id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        if(!Hash::check($model->oldPass, $item->password)) {
            throw new \Exception('Old password is not correct!');
        }

        $updatedItem = $this->repository->ChangePassword($id, $model->newPass);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Password failed to update!');

    }
}
