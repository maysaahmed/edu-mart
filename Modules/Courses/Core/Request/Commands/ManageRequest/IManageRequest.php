<?php

namespace Modules\Courses\Core\Request\Commands\ManageRequest;


interface IManageRequest
{
    public function execute(ManageRequestModel $model): bool|null;
}
