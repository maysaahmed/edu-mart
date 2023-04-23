<?php

namespace Modules\Administration\Core\Admin\Commands\UpdateAdminStatus;

use Modules\Administration\Domain\Entities\Admin\Admin;

interface IUpdateAdminStatus
{
    public function execute(UpdateAdminStatusModel $model): Admin;
}
