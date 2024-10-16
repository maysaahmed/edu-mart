<?php

namespace Modules\Users\Core\User\Commands\ResendVerificationMail;

interface IResendVerificationMail
{
    public function execute(int $email): bool;
}
