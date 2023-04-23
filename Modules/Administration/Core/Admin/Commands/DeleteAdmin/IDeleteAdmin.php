<?php

namespace Modules\Administration\Core\Admin\Commands\DeleteAdmin;

interface IDeleteAdmin
{
    public function execute(DeleteAdminModel $model): bool;
}
