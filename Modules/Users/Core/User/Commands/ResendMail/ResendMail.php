<?php
namespace Modules\Users\Core\User\Commands\ResendMail;

use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Core\User\Repositories\IUserRepository;

class ResendMail implements IResendMail
{

    private IUserRepository $repository;
    private IMailService $mail;

    public function __construct(IUserRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute($user_id): bool
    {
        $item = $this->repository->getUserByID($user_id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        if($item->check_email_status)
            throw new \Exception('User has been already verified!');

        $name = $item->name;
        $email = $item->email;
        $link = env('VERIFY_FRONT_URL').'/'. $item->verifyUser->token;

        $sent = $this->mail->sendMail($email,$name,$link);
        if(!$sent)
        {
            throw new \Exception('Email is invalid!');
        }


        return true;
    }
}
