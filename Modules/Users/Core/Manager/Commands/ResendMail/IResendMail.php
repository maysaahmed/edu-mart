<?php

namespace Modules\Users\Core\Manager\Commands\ResendMail;

interface IResendMail
{
    public function execute(int $user_id): bool;
}
