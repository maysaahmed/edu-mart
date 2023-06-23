<?php
namespace Modules\Organizations\Core\Organization\Queries\GetOrganizationList;

use Illuminate\Database\Eloquent\Collection;

interface IGetOrganizationList
{
    public function execute(): Collection;
}
