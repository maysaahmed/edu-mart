<?php
namespace Modules\Users\Core\User\Commands\VerifyRegisteredUser;

use Modules\Users\Core\User\Repositories\IUserRepository;

class VerifyRegisteredUser implements IVerifyRegisteredUser
{
    public function __construct(
        private IUserRepository $repository,
    )
    {
    }

    public function execute($token): bool
    {
        $verifyUser = $this->repository->getVerifyUserByToken($token);
        if(!$verifyUser){
            throw new \Exception('Token cannot be found!');
        }
        $item = $this->repository->getUserByID($verifyUser->user_id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }
        if($item->check_email_status){
            throw new \Exception('Your e-mail is already verified. You can now login.');
        }

        $verifyItem = $this->repository->verifyRegisteredUser($token);

        if (!$verifyItem){
            throw new \Exception('User failed to verify!');
        }

        return true;
    }
}
