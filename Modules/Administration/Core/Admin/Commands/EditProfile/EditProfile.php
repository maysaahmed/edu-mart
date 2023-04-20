<?php
namespace Modules\Administration\Core\Admin\Commands\EditProfile;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Modules\Administration\Domain\Entities\Admin\Admin;

class EditProfile implements IEditProfile
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(EditProfileModel $model): Admin
    {
        $_profileId = $model->profileId;

        $item =$this->repository->getAdminById($_profileId);

        if(!$item){
            throw new \Exception('Profile cannot be found!');
        }

        $updatedItem = $this->repository->editProfile($_profileId, $model->name, $model->email);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Profile failed to update!');
    }
}
