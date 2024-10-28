<?php
namespace Modules\Users\Core\User\Commands\EditProfile;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\User;

class EditProfile implements IEditProfile
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute(EditProfileModel $model): EndUser
    {
        $_id = $model->id;
        $item = $this->repository->getUserById($_id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        if($_id !== auth()->id())
        {
            throw new \Exception('You cann\'t update this data!');
        }

        $updatedItem = $this->repository->editProfile($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('User failed to update!');
    }
}
