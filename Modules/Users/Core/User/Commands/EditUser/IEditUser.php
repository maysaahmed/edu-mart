<?php

namespace Modules\Users\Core\User\Commands\EditUser;

use Modules\Users\Domain\Entities\EndUser;

interface IEditUser
{
    public function execute(EditUserModel $model): EndUser;
}
