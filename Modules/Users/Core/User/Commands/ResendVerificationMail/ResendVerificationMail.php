<?php
namespace Modules\Users\Core\User\Commands\ResendVerificationMail;

use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Core\User\Repositories\IUserRepository;

class ResendVerificationMail implements IResendVerificationMail
{

    private IUserRepository $repository;
    private IMailService $mail;

    public function __construct(IUserRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute($email): bool
    {
        $item = $this->repository->getUserByEmail($email);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        if($item->check_email_status)
            throw new \Exception('User has been already verified!');

        $name = $item->name;
        $email = $item->email;
        $link = env('VERIFY_REGISTERED_URL').'/'. $item->verifyUser->token;

        $sent = $this->mail->sendUserVerifyMail($email,$name,$link);
        if(!$sent)
        {
            throw new \Exception('Email is invalid!');
        }


        return true;
    }
}
