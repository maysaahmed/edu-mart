<?php

namespace Modules\Courses\Core\Request\Commands\CreateRequest;

use Modules\Courses\Domain\Entities\Request;

interface ICreateRequest
{
    public function execute(CreateRequestModel $model): Request;
}
