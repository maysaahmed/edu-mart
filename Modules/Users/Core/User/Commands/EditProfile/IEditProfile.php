<?php

namespace Modules\Users\Core\User\Commands\EditProfile;

use Modules\Users\Domain\Entities\EndUser;

interface IEditProfile
{
    public function execute(EditProfileModel $model): EndUser;
}
