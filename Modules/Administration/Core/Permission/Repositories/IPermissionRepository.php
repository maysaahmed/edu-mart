<?php

namespace Modules\Administration\Core\Permission\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Support\Collection;


interface IPermissionRepository extends IRepository
{

    public function getPermissions(?int $role_id = null): Collection|null;

}
