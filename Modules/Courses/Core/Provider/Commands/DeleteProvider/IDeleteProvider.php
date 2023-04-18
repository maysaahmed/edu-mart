<?php

namespace Modules\Courses\Core\Provider\Commands\DeleteProvider;


interface IDeleteProvider
{
    public function execute(int $id): bool;
}
