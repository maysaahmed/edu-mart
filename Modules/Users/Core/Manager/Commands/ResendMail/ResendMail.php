<?php
namespace Modules\Users\Core\Manager\Commands\ResendMail;

use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Core\Manager\Repositories\IManagerRepository;

class ResendMail implements IResendMail
{
    private IManagerRepository $repository;
    private IMailService $mail;

    public function __construct(IManagerRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute($user_id): bool
    {
        $item = $this->repository->getManagerByID($user_id);

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
