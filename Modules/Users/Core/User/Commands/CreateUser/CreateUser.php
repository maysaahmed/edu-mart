<?php
namespace Modules\Users\Core\User\Commands\CreateUser;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\User\User;

class CreateUser implements ICreateUser
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute(CreateUserModel $model): User
    {

        return $this->repository->createUser($model->name, $model->email, $model->password, $model->type, $model->roleId, $model->createdBy, $model->isActive);
    }
}
