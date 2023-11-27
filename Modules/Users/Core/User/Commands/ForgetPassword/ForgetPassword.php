<?php
namespace Modules\Users\Core\User\Commands\ForgetPassword;

use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\User;

class ForgetPassword implements IForgetPassword
{

    private IUserRepository $repository;
    private IMailService $mail;

    public function __construct(IUserRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute(string $email): bool
    {
        $item = $this->repository->getUserByEmail($email);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        $token = $this->repository->createUserToken($email);
        if ($token){
            $link = env('RESET_PASSWORD_FRONT_URL').'/'. $token;

            $sent = $this->mail->sendResetPasswordMail($email,$link);
            if(!$sent)
            {
                throw new \Exception('Email is invalid!');
            }
            return $sent;
        }

        throw new \Exception('token failed to send!');
    }
}
