<?php
namespace Modules\Users\Core\Auth\Commands\UserAuth;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Modules\Users\Core\Auth\Repositories\IAuthRepository;
use Modules\Assessment\Core\Result\Repositories\IResultRepository;
use Illuminate\Support\Facades\Hash;
use App\Enums\EnumUserTypes;

class UserAuth implements IUserAuth
{
    public function __construct(
        private IAuthRepository $repository,
        private IOrganizationRepository $organizationRepository,
        private IResultRepository $resultRepository,
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
                if($organization)
                {
                    if (!$organization->status) {
                        throw new \Exception('Your account is blocked!');
                    }
                }
                if (!$user->is_active || !$organization->status) {
                    throw new \Exception('Your account is blocked!');
                }

                $token = ($user->type == EnumUserTypes::Manager->value) ? 'manager-token' : 'user-token';
                $abilities = [];
                if($model->rememberMe)
                    $abilities[] = 'remember';
                $user_token = $user->createToken($token, $abilities)->plainTextToken;
                //check user complete data
                $complete_data = ($user->type == EnumUserTypes::User->value && !isset($user->account)) ? 0 : 1;

                //check if user took the assessment
                $take_assessment = $this->resultRepository->takeAssessment($user->id);

                return ['user' => $user, 'token' => $user_token, 'complete_data' => $complete_data, 'take_assessment' => $take_assessment];
            }

        }

        throw new \Exception('The provided credentials do not match our records.!');
    }
}
