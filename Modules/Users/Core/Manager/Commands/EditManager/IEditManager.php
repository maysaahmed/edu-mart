<?php

namespace Modules\Users\Core\Manager\Commands\EditManager;

use Modules\Users\Domain\Entities\Manager;

interface IEditManager
{
    public function execute(EditManagerModel $model): Manager;
}
