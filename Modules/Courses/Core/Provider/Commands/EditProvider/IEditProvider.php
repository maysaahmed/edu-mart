<?php

namespace Modules\Courses\Core\Provider\Commands\EditProvider;

use Modules\Courses\Domain\Entities\Provider;

interface IEditProvider
{
    public function execute(EditProviderModel $model): Provider;
}
