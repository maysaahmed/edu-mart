<?php

namespace Modules\Users\Core\User\Commands\VerifyUser;

interface IVerifyUser
{
    public function execute(string $token, string $password): bool;
}
