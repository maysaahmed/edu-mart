<?php
namespace Modules\Users\Core\Manager\Queries\GetOrganizationManagers;

use Illuminate\Database\Eloquent\Collection;

interface IGetOrganizationManagers
{
    public function execute(int $org_id): Collection;
}
