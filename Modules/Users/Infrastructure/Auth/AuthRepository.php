<?php
namespace Modules\Users\Infrastructure\Auth;

use App\Infrastructure\Repository\Repository;
use Modules\Users\Core\Auth\Repositories\IAuthRepository;
use Modules\Users\Domain\Entities\EndUser;
use App\Enums\EnumUserTypes;

class AuthRepository extends Repository implements IAuthRepository
{
    protected function model(): string
    {
        return EndUser::class;
    }

    public function getUserByEmail($email): EndUser|null
    {
        return EndUser::where('email', $email)->whereIn('type', [EnumUserTypes::Manager, EnumUserTypes::User])->first();
    }


}
