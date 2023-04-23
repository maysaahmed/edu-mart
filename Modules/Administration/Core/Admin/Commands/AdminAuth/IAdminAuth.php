<?php

namespace Modules\Administration\Core\Admin\Commands\AdminAuth;

interface IAdminAuth
{
    public function execute(AdminAuthModel $model): array;
}
