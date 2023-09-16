<?php
namespace Modules\Users\Core\User\Commands\CompleteUserData;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\User;

class CompleteUserData implements ICompleteUserData
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute(CompleteUserDataModel $model): EndUser
    {
        $_id = $model->user_id;
        $user = $this->repository->getUserById($_id);

        if(!$user){
            throw new \Exception('User cannot be found!');
        }

        $updatedItem = $this->repository->completeUserData($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('User failed to update!');
    }
}
