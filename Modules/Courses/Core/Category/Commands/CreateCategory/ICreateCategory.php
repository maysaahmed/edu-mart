<?php

namespace Modules\Courses\Core\Category\Commands\CreateCategory;

use Modules\Courses\Domain\Entities\Category;

interface ICreateCategory
{
    public function execute(string $name): Category;
}
