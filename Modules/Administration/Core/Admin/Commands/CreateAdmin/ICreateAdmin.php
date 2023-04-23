<?php

namespace Modules\Administration\Core\Admin\Commands\CreateAdmin;

use Modules\Administration\Domain\Entities\Admin\Admin;

interface ICreateAdmin
{
    public function execute(CreateAdminModel $model): Admin;
}
