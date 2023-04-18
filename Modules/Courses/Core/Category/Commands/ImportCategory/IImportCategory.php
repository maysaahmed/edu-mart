<?php

namespace Modules\Courses\Core\Category\Commands\ImportCategory;


interface IImportCategory
{
    public function execute(string $file_path): int;
}
