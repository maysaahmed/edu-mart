<?php
namespace Modules\Users\Core\User\Commands\RegisterUser;

use Modules\Users\Core\User\Repositories\IUserRepository;
use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Domain\Entities\EndUser;

class RegisterUser implements IRegisterUser
{
    private IUserRepository $repository;
    private IMailService $mail;

    public function __construct(IUserRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute(RegisterUserModel $model): EndUser
    {

        $user = $this->repository->registerUser($model);
        $name = $user->name;
        $email = $user->email;
        $link = env('VERIFY_REGISTERED_URL').'/'. $user->verifyUser->token;

        $sent = $this->mail->sendUserVerifyMail($email,$name,$link);
        if(!$sent)
        {
            throw new \Exception('Email is invalid!');
        }

        return $user;
    }
}
