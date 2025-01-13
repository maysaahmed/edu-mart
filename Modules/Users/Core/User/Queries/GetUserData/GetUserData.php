<?php
namespace Modules\Users\Core\User\Queries\GetUserData;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;


class GetUserData implements IGetUserData
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): EndUser
    {
        $user = $this->repository->getUserById($id);
        if($user == null){
            throw new \Exception('User cannot be found!');
        }
        return $user;
    }
}
