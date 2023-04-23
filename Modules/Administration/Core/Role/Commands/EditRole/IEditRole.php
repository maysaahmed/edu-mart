<?php

namespace Modules\Administration\Core\Role\Commands\EditRole;

use Spatie\Permission\Models\Role;

interface IEditRole
{
    public function execute(EditRoleModel $model): Role;
}
