<?php
namespace Modules\Users\Core\User\Queries\GetUserProfile;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;


class GetUserProfile implements IGetUserProfile
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): EndUser
    {
        $user_id = auth()->id();
        return $this->repository->getUserById($user_id);
    }
}
