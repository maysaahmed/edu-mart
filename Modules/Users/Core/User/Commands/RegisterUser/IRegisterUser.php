<?php

namespace Modules\Users\Core\User\Commands\RegisterUser;

use Modules\Users\Domain\Entities\EndUser;

interface IRegisterUser
{
    public function execute(RegisterUserModel $model): EndUser;
}
