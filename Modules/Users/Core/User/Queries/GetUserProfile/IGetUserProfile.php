<?php
namespace Modules\Users\Core\User\Queries\GetUserProfile;
use Modules\Users\Domain\Entities\EndUser;

interface IGetUserProfile
{
    public function execute(): EndUser;
}
