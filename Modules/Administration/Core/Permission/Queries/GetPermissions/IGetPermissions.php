<?php
namespace Modules\Administration\Core\Permission\Queries\GetPermissions;
use Illuminate\Support\Collection;

interface IGetPermissions
{
    public function execute(?int $id = null): Collection;
}
