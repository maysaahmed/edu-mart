<?php
namespace Modules\Users\Core\User\Commands\EditUser;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\User;

class EditUser implements IEditUser
{
    public function __construct(
        private IUserRepository $repository,
        private IManagerRepository $managerRepository
    )
    {
    }

    public function execute(EditUserModel $model): EndUser
    {
        $_id = $model->id;
        $item = $this->repository->getUserById($_id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        $manager = $this->managerRepository->getManagerById($model->updatedBy);

        if($item->organization_id !== $manager->organization_id){
            throw new \Exception('You cannot update this user!');
        }

        $updatedItem = $this->repository->editUser($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('User failed to update!');
    }
}
