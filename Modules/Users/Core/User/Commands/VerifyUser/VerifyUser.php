<?php
namespace Modules\Users\Core\User\Commands\VerifyUser;

use Modules\Users\Core\User\Repositories\IUserRepository;

class VerifyUser implements IVerifyUser
{
    public function __construct(
        private IUserRepository $repository,
    )
    {
    }

    public function execute($token, $password): bool
    {
        $verifyUser = $this->repository->getVerifyUserByToken($token);
        $item = $this->repository->getUserByID($verifyUser->user_id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }
        if($item->check_email_status){
            throw new \Exception('Your e-mail is already verified. You can now login.');
        }

        $verifyItem = $this->repository->verifyUser($token, $password);

        if (!$verifyItem){
            throw new \Exception('User failed to verify!');
        }

        return true;
    }
}
