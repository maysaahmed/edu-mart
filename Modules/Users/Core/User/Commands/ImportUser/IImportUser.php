<?php

namespace Modules\Users\Core\User\Commands\ImportUser;


interface IImportUser
{
    public function execute(string $file_path): int;
}
