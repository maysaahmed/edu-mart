<?php

namespace Modules\Administration\Core\Admin\Commands\EditAdmin;

use Modules\Administration\Domain\Entities\Admin\Admin;

interface IEditAdmin
{
    public function execute(EditAdminModel $model): Admin;
}
