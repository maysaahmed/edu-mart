<?php

namespace Modules\Courses\Core\Course\Commands\ImportCourse;


interface IImportCourse
{
    public function execute(string $file_path): int;
}
