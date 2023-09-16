<?php

namespace Modules\Users\Core\User\Commands\CompleteUserData;

use Modules\Users\Domain\Entities\EndUser;

interface ICompleteUserData
{
    public function execute(CompleteUserDataModel $model): EndUser;
}
