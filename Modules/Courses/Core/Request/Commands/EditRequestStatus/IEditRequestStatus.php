<?php

namespace Modules\Courses\Core\Request\Commands\EditRequestStatus;


interface IEditRequestStatus
{
    public function execute(int $id, int $status): bool|null;
}
