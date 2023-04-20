<?php

namespace Modules\Administration\Core\Admin\Commands\EditProfile;

use Modules\Administration\Domain\Entities\Admin\Admin;

interface IEditProfile
{
    public function execute(EditProfileModel $model): Admin;
}
