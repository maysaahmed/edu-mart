<?php

namespace Modules\Organizations\Core\Organization\Commands\CreateOrganization;

use Modules\Organizations\Domain\Entities\Organization\Organization;

interface ICreateOrganization
{
    public function execute(CreateOrganizationModel $model): Organization;
}
