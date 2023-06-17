<?php

namespace Modules\Users\Core\Manager\Commands\EditManagerStatus;

use Modules\Users\Domain\Entities\Manager;

interface IEditManagerStatus
{
    public function execute(EditManagerStatusModel $model): Manager;
}
