<?php

namespace Modules\Users\Core\User\Commands\RemoveProfileImage;


interface IRemoveProfileImage
{
    public function execute($id): bool;
}
