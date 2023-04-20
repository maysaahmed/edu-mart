<?php

namespace Modules\Administration\Core\Role\Commands\CreateRole;

use Spatie\Permission\Models\Role;

interface ICreateRole
{
    public function execute(string $name): Role;
}
