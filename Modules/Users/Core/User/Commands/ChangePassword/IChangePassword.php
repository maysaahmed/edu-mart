<?php

namespace Modules\Users\Core\User\Commands\ChangePassword;

use Modules\Users\Domain\Entities\EndUser;

interface IChangePassword
{
    public function execute(ChangePasswordModel $model): EndUser;
}
