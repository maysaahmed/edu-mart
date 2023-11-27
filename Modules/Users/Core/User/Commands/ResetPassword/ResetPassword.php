<?php
namespace Modules\Users\Core\User\Commands\ResetPassword;

use Modules\Users\Core\User\Repositories\IUserRepository;

class ResetPassword implements IResetPassword
{
    public function __construct(
        private IUserRepository $repository,
    )
    {
    }

    public function execute($token, $password): bool
    {
        $resetToken = $this->repository->getResetByToken($token);
        if(!$resetToken){
            throw new \Exception('Token cannot be found!');
        }
        $item = $this->repository->getUserByEmail($resetToken->email);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        $resetPassword = $this->repository->resetPassword($token, $password);

        if (!$resetPassword){
            throw new \Exception('password failed to reset!');
        }

        return true;
    }
}
