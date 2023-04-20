<?php

namespace Modules\Courses\Core\Category\Commands\EditCategory;
use Spatie\LaravelData\Data;

class EditCategoryModel extends Data
{

    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

}
