<?php

namespace Modules\Courses\Core\Level\Commands\ImportLevel;


interface IImportLevel
{
    public function execute(string $file_path): int;
}
