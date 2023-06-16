<?php

namespace Modules\Users\Core\User\Commands\CreateUser;

use App\Core\User\Commands\CreateUser\CreateUserModel;
use Modules\Users\Domain\Entities\EndUser;

interface ICreateUser
{
    public function execute(CreateUserModel $model): EndUser;
}
