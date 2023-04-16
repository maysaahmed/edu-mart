<?php

namespace Modules\Organizations\Core\Organization\Commands\ImportOrganization;


interface IImportOrganization
{
    public function execute(string $file_path): int;
}
