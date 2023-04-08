<?php

namespace App\Core\User\Commands\CreateUser;

use App\Domain\Entities\User\User;

interface ICreateUser
{
    public function execute(CreateUserModel $model): User;
}
