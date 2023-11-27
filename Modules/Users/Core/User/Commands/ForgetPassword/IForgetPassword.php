<?php

namespace Modules\Users\Core\User\Commands\ForgetPassword;


interface IForgetPassword
{
    public function execute(string $email): bool;
}
