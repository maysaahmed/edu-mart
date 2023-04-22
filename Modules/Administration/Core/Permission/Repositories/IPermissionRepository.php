<?php

namespace Modules\Administration\Core\Permission\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Support\Collection;


interface IPermissionRepository extends IRepository
{

    public function getPermissions(?int $id = null): Collection|null;

}
