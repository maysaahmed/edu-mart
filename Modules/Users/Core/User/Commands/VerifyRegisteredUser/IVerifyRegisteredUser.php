<?php

namespace Modules\Users\Core\User\Commands\VerifyRegisteredUser;

interface IVerifyRegisteredUser
{
    public function execute(string $token): bool;
}
