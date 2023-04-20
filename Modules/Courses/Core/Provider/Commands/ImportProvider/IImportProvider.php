<?php

namespace Modules\Courses\Core\Provider\Commands\ImportProvider;


interface IImportProvider
{
    public function execute(string $file_path): int;
}
