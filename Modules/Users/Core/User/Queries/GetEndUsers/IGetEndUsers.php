<?php
namespace Modules\Users\Core\User\Queries\GetEndUsers;

use Illuminate\Database\Eloquent\Collection;

interface IGetEndUsers
{
    public function execute(): Collection;
}
