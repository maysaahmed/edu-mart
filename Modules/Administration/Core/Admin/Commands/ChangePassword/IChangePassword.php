<?php

namespace Modules\Administration\Core\Admin\Commands\ChangePassword;

use Modules\Administration\Domain\Entities\Admin\Admin;

interface IChangePassword
{
    public function execute(ChangePasswordModel $model): Admin;
}
