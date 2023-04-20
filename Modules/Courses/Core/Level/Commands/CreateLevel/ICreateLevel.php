<?php

namespace Modules\Courses\Core\Level\Commands\CreateLevel;

use Modules\Courses\Domain\Entities\Level;

interface ICreateLevel
{
    public function execute(string $name): Level;
}
