<?php

namespace Modules\Organizations\Core\Organization\Commands\DeleteOrganization;

interface IDeleteOrganization
{
    public function execute(int $id): bool;
}
