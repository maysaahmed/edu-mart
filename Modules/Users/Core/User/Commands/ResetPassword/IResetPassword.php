<?php

namespace Modules\Users\Core\User\Commands\ResetPassword;

interface IResetPassword
{
    public function execute(string $token, string $password): bool;
}
