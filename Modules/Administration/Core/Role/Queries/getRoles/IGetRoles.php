<?php
namespace Modules\Administration\Core\Role\Queries\GetRoles;
use Illuminate\Support\Collection;

interface IGetRoles
{
    public function execute(): Collection;
}
