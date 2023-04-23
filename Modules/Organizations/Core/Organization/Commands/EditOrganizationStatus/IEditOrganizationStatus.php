<?php

namespace Modules\Organizations\Core\Organization\Commands\EditOrganizationStatus;

use Modules\Organizations\Domain\Entities\Organization\Organization;

interface IEditOrganizationStatus
{
    public function execute(EditOrganizationStatusModel $model): Organization;
}
