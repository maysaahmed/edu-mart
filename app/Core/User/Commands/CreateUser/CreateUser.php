<?php

namespace App\Core\User\Commands\CreateUser;

use App\Domain\Entities\User\User;

class CreateUser implements ICreateUser
{
    public function __construct()
    {

    }

    public function execute(CreateUserModel $model): User
    {

        $user = new User();
        $user->name = $model->name;
        $user->email = $model->email;
        $user->password = bcrypt($model->password);
        $user->save();

        return $user;
    }
}
