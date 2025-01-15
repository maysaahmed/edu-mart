<?php
namespace Modules\Users\Core\User\Queries\GetUserData;
use Modules\Users\Domain\Entities\EndUser;

interface IGetUserData
{
    public function execute(int $id): EndUser;
}
