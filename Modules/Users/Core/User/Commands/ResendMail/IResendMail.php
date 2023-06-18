<?php

namespace Modules\Users\Core\User\Commands\ResendMail;

interface IResendMail
{
    public function execute(int $user_id): bool;
}
