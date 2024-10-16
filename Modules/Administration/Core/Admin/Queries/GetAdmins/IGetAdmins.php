<?php
namespace Modules\Administration\Core\Admin\Queries\GetAdmins;

use Illuminate\Support\Collection;

interface IGetAdmins
{
    public function execute(): Collection;
}
