<?php

namespace Modules\Users\Core\Auth\Commands\UserAuth;

interface IUserAuth
{
    public function execute(UserAuthModel $model): array;
}
