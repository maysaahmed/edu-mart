<?php

namespace Modules\Users\Core\Manager\Commands\DeleteManager;

interface IDeleteManager
{
    public function execute(int $id, int $deletedBy): bool;
}
