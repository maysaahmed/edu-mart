<?php

namespace Modules\Organizations\Core\Organization\Commands\EditOrganization;

use Modules\Organizations\Domain\Entities\Organization\Organization;

interface IEditOrganization
{
    public function execute(EditOrganizationModel $model): Organization;
}
