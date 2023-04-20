<?php

namespace Modules\Courses\Core\Category\Commands\DeleteCategory;


interface IDeleteCategory
{
    public function execute(int $id): bool;
}
