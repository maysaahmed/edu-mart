<?php
namespace Modules\Administration\Core\Role\Queries\getRoles;
use Illuminate\Support\Collection;

interface IGetRoles
{
    public function execute(): Collection;
}
