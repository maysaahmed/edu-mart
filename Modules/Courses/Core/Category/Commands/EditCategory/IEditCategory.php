<?php

namespace Modules\Courses\Core\Category\Commands\EditCategory;

use Modules\Courses\Domain\Entities\Category;

interface IEditCategory
{
    public function execute(EditCategoryModel $model): Category;
}
