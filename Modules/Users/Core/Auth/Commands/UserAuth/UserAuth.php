<?php
namespace Modules\Users\Core\Auth\Commands\UserAuth;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Modules\Users\Core\Auth\Repositories\IAuthRepository;
use Illuminate\Support\Facades\Hash;
use App\Enums\EnumUserTypes;

class UserAuth implements IUserAuth
{
    public function __construct(
        private IAuthRepository $repository,
        private IOrganizationRepository $organizationRepository
    )
    {
    }

    public function execute(UserAuthModel $model): array
    {
        $user = $this->repository->getUserByEmail($model->email);

        if ($user) {
            if(!$user->is_active)
            {
                throw new \Exception('The user account is blocked!');
            }

            if($user->check_email_status == 0)
            {
                throw new \Exception('You need to confirm your account. We have sent you an email, please check your email.');
            }

            if (Hash::check($model->password, $user->password)) {

                //check user organization is blocked or user is blocked
                $organization = $this->organizationRepository->getOrganizationById($user->organization_id);
                if (!$user->is_active || !$organization->status) {
                    throw new \Exception('Your account is blocked!');
                }

                $token = ($user->type == EnumUserTypes::Manager->value) ? 'manager-token' : 'user-token';

                $user_token = $user->createToken($token, [])->plainTextToken;
                return ['user' => $user, 'token' => $user_token];
            }

        }

        throw new \Exception('The provided credentials do not match our records.!');
    }
}
