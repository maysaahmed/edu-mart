<?php
namespace Modules\Users\Core\Auth\Repositories;

use App\Core\Repository\IRepository;
use Modules\Users\Domain\Entities\EndUser;

interface IAuthRepository extends IRepository
{
    public function getUserByEmail($email): EndUser|null;

}
