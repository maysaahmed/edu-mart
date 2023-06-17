<?php
namespace Modules\Users\Core\User\Commands\CreateUser;

use Illuminate\Support\Str;
use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;

class CreateUser implements ICreateUser
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute(CreateUserModel $model): EndUser
    {
        $randomPassword = Str::random(12);
        return $this->repository->createUser($model->name, $model->email, $randomPassword, $model->organizationId, $model->createdBy, $model->isActive);
    }
}
