<?php

namespace Modules\Users\Core\Manager\Commands\CreateManager;

use Modules\Users\Domain\Entities\Manager;

interface ICreateManager
{
    public function execute(CreateManagerModel $model): Manager;
}
