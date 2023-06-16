<?php
namespace Modules\Users\Core\User\Commands\DeleteUser;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Core\Manager\Repositories\IManagerRepository;

class DeleteUser implements IDeleteUser
{
    public function __construct(
        private IUserRepository $repository,
        private IManagerRepository $managerRepository,
    )
    {
    }

    public function execute($id, $deletedBy): bool
    {
        $item =$this->repository->getUserByID($id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        $manager = $this->managerRepository->getManagerByID($deletedBy);

        if($item->organization_id !== $manager->organization_id){
            throw new \Exception('You cannot delete this user!');
        }



        $deleteItem = $this->repository->deleteUser($id, $deletedBy);

        if (!$deleteItem){
            throw new \Exception('User failed to remove!');
        }

        return true;
    }
}
