<?php

namespace App\Core\User\Commands\CreateUser;

use App\Core\User\Repositories\IUserRepository;
use App\Domain\Entities\User\User;

class CreateUser implements ICreateUser
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateUserModel $model): User
    {
        return $this->repository->createUser($model);
    }
}
