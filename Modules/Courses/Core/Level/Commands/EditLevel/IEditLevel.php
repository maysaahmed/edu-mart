<?php

namespace Modules\Courses\Core\Level\Commands\EditLevel;

use Modules\Courses\Domain\Entities\Level;

interface IEditLevel
{
    public function execute(EditLevelModel $model): Level;
}
