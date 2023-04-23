<?php

namespace Modules\Courses\Core\Level\Commands\DeleteLevel;


interface IDeleteLevel
{
    public function execute(int $id): bool;
}
