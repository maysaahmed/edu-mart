<?php
namespace Modules\Users\Core\User\Commands\CreateUser;

use Modules\Users\Core\User\Repositories\IUserRepository;
use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Domain\Entities\EndUser;

class CreateUser implements ICreateUser
{
    private IUserRepository $repository;
    private IMailService $mail;

    public function __construct(IUserRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute(CreateUserModel $model): EndUser
    {

        $user = $this->repository->createUser($model);
        $name = $user->name;
        $email = $user->email;
        $link = env('FRONT_URL').'/user/verify/'. $user->verifyUser->token;

        $sent = $this->mail->sendMail($email,$name,$link);
        if(!$sent)
        {
            throw new \Exception('Email is invalid!');
        }

        return $user;
    }
}
