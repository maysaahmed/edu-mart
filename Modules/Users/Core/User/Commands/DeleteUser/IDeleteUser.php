<?php

namespace Modules\Users\Core\User\Commands\DeleteUser;

interface IDeleteUser
{
    public function execute(int $id, int $deletedBy): bool;
}
