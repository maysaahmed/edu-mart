<?php

namespace Modules\Users\Core\Manager\Commands\ImportManager;


interface IImportManager
{
    public function execute(string $file_path): int;
}
