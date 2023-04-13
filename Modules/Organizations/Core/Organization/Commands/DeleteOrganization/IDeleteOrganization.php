<?php

namespace Modules\Organizations\Core\Organization\Commands\DeleteOrganization;

use Modules\Organizations\Domain\Entities\Organization\Organization;

interface IDeleteOrganization
{
    public function execute(int $id): bool;
}
