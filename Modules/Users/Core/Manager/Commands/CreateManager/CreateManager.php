<?php
namespace Modules\Users\Core\Manager\Commands\CreateManager;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use App\Core\Interfaces\Services\IMailService;
use Modules\Users\Domain\Entities\Manager;

class CreateManager implements ICreateManager
{
    private IManagerRepository $repository;
    private IMailService $mail;

    public function __construct(IManagerRepository $repository, IMailService $mail)
    {
        $this->repository = $repository;
        $this->mail = $mail;
    }

    public function execute(CreateManagerModel $model): Manager
    {

        $user = $this->repository->createManager($model);
        $name = $user->name;
        $email = $user->email;
        $link = env('VERIFY_FRONT_URL').'/'. $user->verifyUser->token;

        $sent = $this->mail->sendMail($email,$name,$link);
        if(!$sent)
        {
            throw new \Exception('Email is invalid!');
        }

        return $user;
    }
}
