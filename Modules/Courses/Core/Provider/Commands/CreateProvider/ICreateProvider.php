<?php

namespace Modules\Courses\Core\Provider\Commands\CreateProvider;

use Modules\Courses\Domain\Entities\Provider;

interface ICreateProvider
{
    public function execute(string $name): Provider;
}
